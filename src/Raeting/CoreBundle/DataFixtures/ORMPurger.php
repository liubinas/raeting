<?php

namespace Raeting\CoreBundle\DataFixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Internal\CommitOrderCalculator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\DataFixtures\Purger\ORMPurger as Purger;

/**
 * Class responsible for purging databases of data before reloading data fixtures.
 *
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
class ORMPurger extends Purger
{
    const PURGE_MODE_DELETE = 1;
    const PURGE_MODE_TRUNCATE = 2;

    /** EntityManager instance used for persistence. */
    protected $em;

    /**
     * If the purge should be done through DELETE or TRUNCATE statements
     *
     * @var int
     */
    protected $purgeMode = self::PURGE_MODE_DELETE;

    /**
     * Construct new purger instance.
     *
     * @param EntityManager $em EntityManager instance used for persistence.
     */
    public function __construct(EntityManager $em = null)
    {
        $this->em = $em;
    }

    /**
     * Set the purge mode
     *
     * @param $mode
     * @return void
     */
    public function setPurgeMode($mode)
    {
        $this->purgeMode = $mode;
    }

    /**
     * Get the purge mode
     *
     * @return int
     */
    public function getPurgeMode()
    {
        return $this->purgeMode;
    }

    /**
     * Set the EntityManager instance this purger instance should use.
     *
     * @param EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
      $this->em = $em;
    }

    /**
     * Retrieve the EntityManager instance this purger instance is using.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getObjectManager()
    {
        return $this->em;
    }
    
    /** @inheritDoc */
    public function purge()
    {
        $classes = array();
        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();

        foreach ($metadatas as $metadata) {
            if ( ! $metadata->isMappedSuperclass) {
                $classes[] = $metadata;
            }
        }

        $commitOrder = $this->getCommitOrder($this->em, $classes);

        // Drop association tables first
        $orderedTables = $this->getAssociationTables($commitOrder);

        // Get platform parameters
        $platform = $this->em->getConnection()->getDatabasePlatform();

        // Drop tables in reverse commit order
        for ($i = count($commitOrder) - 1; $i >= 0; --$i) {
            $class = $commitOrder[$i];

            if (($class->isInheritanceTypeSingleTable() && $class->name != $class->rootEntityName)
                || $class->isMappedSuperclass) {
                continue;
            }

            $orderedTables[] = $class->getQuotedTableName($platform);
        }
        
        $this->em->getConnection()->executeUpdate("SET FOREIGN_KEY_CHECKS = 0");
        foreach($orderedTables as $tbl) {
            if($tbl != 'user_stats' && $tbl != 'analyst_total_return' && $tbl != 'benchmark'){
                if ($this->purgeMode === self::PURGE_MODE_DELETE) {
                    $this->em->getConnection()->executeUpdate("DELETE FROM " . $tbl);
                } else {
                    $this->em->getConnection()->executeUpdate($platform->getTruncateTableSQL($tbl, true));
                }
            }
        }
        $this->em->getConnection()->executeUpdate("SET FOREIGN_KEY_CHECKS = 1");
    }
    
    protected function getCommitOrder(EntityManager $em, array $classes)
    {
        $calc = new CommitOrderCalculator;

        foreach ($classes as $class) {
            $calc->addClass($class);

            // $class before its parents
            foreach ($class->parentClasses as $parentClass) {
                $parentClass = $em->getClassMetadata($parentClass);

                if ( ! $calc->hasClass($parentClass->name)) {
                    $calc->addClass($parentClass);
                }

                $calc->addDependency($class, $parentClass);
            }

            foreach ($class->associationMappings as $assoc) {
                if ($assoc['isOwningSide']) {
                    $targetClass = $em->getClassMetadata($assoc['targetEntity']);

                    if ( ! $calc->hasClass($targetClass->name)) {
                        $calc->addClass($targetClass);
                    }

                    // add dependency ($targetClass before $class)
                    $calc->addDependency($targetClass, $class);

                    // parents of $targetClass before $class, too
                    foreach ($targetClass->parentClasses as $parentClass) {
                        $parentClass = $em->getClassMetadata($parentClass);

                        if ( ! $calc->hasClass($parentClass->name)) {
                            $calc->addClass($parentClass);
                        }

                        $calc->addDependency($parentClass, $class);
                    }
                }
            }
        }

        return $calc->getCommitOrder();
    }

    protected function getAssociationTables(array $classes)
    {
        $associationTables = array();

        foreach ($classes as $class) {
            foreach ($class->associationMappings as $assoc) {
                if ($assoc['isOwningSide'] && $assoc['type'] == ClassMetadata::MANY_TO_MANY) {
                    $associationTables[] = $assoc['joinTable']['name'];
                }
            }
        }

        return $associationTables;
    }
}

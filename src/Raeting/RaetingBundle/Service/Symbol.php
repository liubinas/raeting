<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

class Symbol
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNew()
    {
        return new Entity\Symbol();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\Market $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function delete($param)
    {
        if (is_int($param)) {
            $entity = $this->get($param);
        } else {
            $entity = $param;
        }

        $this->em->remove($entity);
        $this->em->flush();
    }

    public function getRepository()
    {
        return $this->em->getRepository('RaetingRaetingBundle:Symbol');
    }
    
    public function getBySymbol($symbol)
    {
        return $this->getRepository()->findOneBy(array('symbol' => $symbol));
    }
    
    public function getSymbolsForStockImport()
    {
        return $this->getRepository()->getSymbolsForStockImport($this->em);
    }
    
    public function findSymbolsByKeyword($query, $maxRows)
    {
        return $this->getRepository()->findSymbolsByKeyword($query, $maxRows);
    }
    
    public function getSymbolTables()
    {
        $query = 'SHOW TABLES';
        
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $tables = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        
        $symbolTables = array();
        if(!empty($tables)){
            foreach($tables as $table){
                if(strpos($table, 'symbol_') !== false){
                    $symbolTables[$table] = $table;
                }
            }
        }
        return $symbolTables;
    }
    
    public function createTable($symbol)
    {
        $conn = $this->em->getConnection();
        $tableName = 'symbol_'.strtolower($symbol);
        $query = "CREATE TABLE IF NOT EXISTS `".addslashes($tableName)."` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `symbol_id` int(11) NOT NULL,
                    `bid` decimal(10,6) NOT NULL,
                    `ask` decimal(10,6) NOT NULL,
                    `high` decimal(10,6) DEFAULT NULL,
                    `low` decimal(10,6) DEFAULT NULL,
                    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `source_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        return $conn->exec($query);
    }
    
    public function deleteTable($tableName)
    {
        $conn = $this->em->getConnection();
        $query = "DROP TABLE `".addslashes($tableName)."`";
        return $conn->exec($query);
    }
}

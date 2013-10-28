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
}

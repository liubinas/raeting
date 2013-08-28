<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

class Ticker
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNew()
    {
        return new Entity\Ticker();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\Ticker $entity)
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
        return $this->em->getRepository('RaetingRaetingBundle:Ticker');
    }
}

<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

class Quote
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNew()
    {
        return new Entity\Quote();
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
        return $this->em->getRepository('RaetingRaetingBundle:Quote');
    }
    
    public function findByKeyword($keyword, $limit)
    {
        $query = $this->getRepository()->createQueryBuilder('p')
            ->where('p.title LIKE :keyword')
            ->setParameter('keyword', '%'.$keyword.'%')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }
}

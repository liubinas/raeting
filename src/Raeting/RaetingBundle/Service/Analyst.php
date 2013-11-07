<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

use Raeting\RaetingBundle\Service\AnalysisService;
class Analyst
{

    public function __construct(EntityManager $em, Analysis $analysisService)
    {
        $this->em = $em;
        $this->analysisService = $analysisService;
    }

    public function getNew()
    {
        return new Entity\Analyst();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\Analyst $entity)
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
        return $this->em->getRepository('RaetingRaetingBundle:Analyst');
    }
    
    public function getAllWithPaging($perPage, $page)
    {
        return $this->getRepository()->getAllWithPaging($perPage, $page);
    }
    
    public function countAll()
    {
        return $this->getRepository()->countAll();
    }
    
    public function getByName($name)
    {
        return $this->getRepository()->findOneByName($name);
    }
    
    public function getByImportSlug($slug)
    {
        return $this->getRepository()->findOneByImportSlug($slug);
    }
    
    public function getBySlug($slug)
    {
        return $this->getRepository()->findOneBySlug($slug);
    }
    
    public function prepareListingData($analysts)
    {
        $data = array();
        if(!empty($analysts)){
            foreach($analysts as $analyst){
                $analystData = array();
                $analystData['name'] = $analyst->getName();
                $analystData['company'] = $analyst->getCompany();
                $analystData['slug'] = $analyst->getSlug();
                $analystData['totalAnalysis'] = $this->analysisService->countAllByAnalyst($analyst);
                $analystData['lastAnalysis'] = $this->analysisService->getLastDateByAnalyst($analyst);
                $data[] = $analystData;
            }
        }
        return $data;
    }
}

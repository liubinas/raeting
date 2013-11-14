<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

use Raeting\RaetingBundle\Service\Analysis;
use Raeting\RaetingBundle\Service\Rate;

class Analyst
{

    public function __construct(EntityManager $em, Analysis $analysisService, Rate $rateService, Dividend $dividendService)
    {
        $this->em = $em;
        $this->analysisService = $analysisService;
        $this->rateService = $rateService;
        $this->dividendService = $dividendService;
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
    
    /**
     * Get all analysts with paging
     * 
     * @param type $perPage
     * @param type $page
     * @return type
     */
    public function getAllWithPaging($perPage, $page)
    {
        return $this->getRepository()->getAllWithPaging($perPage, $page);
    }
    
    /**
     * get number of total analysts
     * 
     * @return type
     */
    public function countAll()
    {
        return $this->getRepository()->countAll();
    }
    
    /**
     * get analyst by name
     * 
     * @param type $name
     * @return type
     */
    public function getByName($name)
    {
        return $this->getRepository()->findOneByName($name);
    }
    
    /**
     * get analyst by import slug
     * 
     * @param type $slug
     * @return type
     */
    public function getByImportSlug($slug)
    {
        return $this->getRepository()->findOneByImportSlug($slug);
    }
    
    /**
     * get analyst by slug
     * 
     * @param type $slug
     * @return type
     */
    public function getBySlug($slug)
    {
        return $this->getRepository()->findOneBySlug($slug);
    }
    
    /**
     * get data for analysts table listing
     * 
     * @param array $analysts
     * @return type
     */
    public function prepareListingData(array $analysts)
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
                $lastSymbols = $this->analysisService->getLastSymbolsByAnalyst($analyst, 3);
                $lastSymbolsString = '';
                if(!empty($lastSymbols)){
                    foreach($lastSymbols as $analysis){
                        $lastSymbolsString .= $analysis->getTicker()->getTitle().', ';
                    }
                    $lastSymbolsString = substr($lastSymbolsString, 0, -2);
                }
                $analystData['lastSymbols'] = $lastSymbolsString;
                $data[] = $analystData;
            }
        }
        return $data;
    }
    
    private function calculateTotalReturnForBuy($ticker, $dateFrom, $dateTo)
    {
        $priceFrom = $this->rateService->getRateByTickerAndDate($ticker, $dateFrom->format('Y-m-d'));
        $priceto = $this->rateService->getRateByTickerAndDate($ticker, $dateto->format('Y-m-d'));
        $dividends = $this->dividendService->getByInterval($dateFrom, $dateTo);
        if(!empty($priceFrom) && !empty($priceTo)){
            $totalReturn = $priceFrom['bid']/($priceTo['bid']);
        }
    }
    
    private function calculateTotalReturnForSell($ticker, $dateFrom, $dateTo)
    {
        
    }
    
    private function calculateTotalReturnByAnalystAndTicker(Entity\Analyst $analyst, $ticker){
        $analyses = $this->analysisService->getAllByAnalystAndTickerAscending($analyst, $ticker);
        if(!empty($analyses)){
            $prevRecommendation = $analyses[0]->getRecommendation();
            $dateFrom = $analyses[0]->getDate();
            foreach($analyses as $analysis){
                $recommendation = $analysis->getRecommendation();
                $dateTo = $analysis->getDate();
                if($recommendation != $prevRecommendation){
                    if($prevRecommendation == Entity\Analysis::RECOMMENDATION_BUY && $recommendation == Entity\Analysis::RECOMMENDATION_HOLD){
                        $this->calculateTotalReturnForBuy($ticker, $dateFrom, $dateTo);
                    }elseif($prevRecommendation == Entity\Analysis::RECOMMENDATION_BUY && $recommendation == Entity\Analysis::RECOMMENDATION_SELL){
                        $this->calculateTotalReturnForBuy($ticker, $dateFrom, $dateTo);
                        $dateFrom = $analysis->getDate();
                    }elseif($prevRecommendation == Entity\Analysis::RECOMMENDATION_SELL && $recommendation == Entity\Analysis::RECOMMENDATION_HOLD){
                        $this->calculateTotalReturnForSell($ticker, $dateFrom, $dateTo);
                    }elseif($prevRecommendation == Entity\Analysis::RECOMMENDATION_SELL && $recommendation == Entity\Analysis::RECOMMENDATION_BUY){
                        $this->calculateTotalReturnForSell($ticker, $dateFrom, $dateTo);
                        $dateFrom = $analysis->getDate();
                    }elseif($prevRecommendation == Entity\Analysis::RECOMMENDATION_HOLD){
                        $dateFrom = $analysis->getDate();
                    }
                }
            }
        }
    }
    
    
    public function calculateTotalReturnByAnalyst(Entity\Analyst $analyst)
    {
        $tickers = $this->analysisService->getAnalystTickers($analyst);
        if(!empty($tickers)){
            foreach($tickers as $ticker){
                $this->calculateTotalReturnByAnalystAndTicker($analyst, $ticker['symbol']);
            }
        }
    }
}

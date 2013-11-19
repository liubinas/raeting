<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

use Raeting\RaetingBundle\Service\Analysis;
use Raeting\RaetingBundle\Service\Rate;
use Raeting\RaetingBundle\Templating\Helper\RaetingHelper;

class Analyst
{

    public function __construct(EntityManager $em, Analysis $analysisService, Rate $rateService, Dividend $dividendService, RaetingHelper $raetingHelper)
    {
        $this->em = $em;
        $this->analysisService = $analysisService;
        $this->rateService = $rateService;
        $this->dividendService = $dividendService;
        $this->raetingHelper = $raetingHelper;
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
     * Get all analysts with paging for rating listing
     * 
     * @param type $perPage
     * @param type $page
     * @return type
     */
    public function getAllForRatingWithPaging($perPage, $page)
    {
        return $this->getRepository()->getAllForRatingWithPaging($perPage, $page);
    }
    
    /**
     * get number of total analysts for rating listing
     * 
     * @return type
     */
    public function countAllForRating()
    {
        return $this->getRepository()->countAllForRating();
    }
    
    /**
     * Get all analysts with paging for rating listing
     * 
     * @param type $perPage
     * @param type $page
     * @return type
     */
    public function getAllForRatingWithPagingByQuery($perPage, $page, $query)
    {
        return $this->getRepository()->getAllForRatingWithPagingByQuery($perPage, $page, $query);
    }
    
    /**
     * get number of total analysts for rating listing
     * 
     * @return type
     */
    public function countAllForRatingByQuery($query)
    {
        return $this->getRepository()->countAllForRatingByQuery($query);
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
                $analystData['totalReturn'] = $analyst->getTotalReturn()->getValue();
                $analystData['rank'] = $analyst->getRank();
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
    
    private function calculateTotalReturn($ticker, $dateFrom, $dateTo, $type)
    {
        $totalReturn = 0;
        $priceFrom = $this->rateService->getRateByTickerAndDate($ticker, $dateFrom->format('Y-m-d'));
        $priceTo = $this->rateService->getRateByTickerAndDate($ticker, $dateTo->format('Y-m-d'));
        $dividends = $this->dividendService->getSumByInterval($ticker, $dateFrom, $dateTo);
        if(!empty($priceFrom) && !empty($priceTo)){
            if($type == 'buy'){
                $totalReturn = ($priceFrom['bid']+$dividends)/($priceTo['bid'])-1;
            }else{
                $totalReturn = ($priceFrom['bid']+$dividends)/($priceTo['bid'])-1;
            }
        }
        return $totalReturn;
    }
    
    private function calculateTotalReturnForBuy($ticker, $dateFrom, $dateTo)
    {
        return $this->calculateTotalReturn($ticker, $dateFrom, $dateTo, 'buy');
    }
    
    private function calculateTotalReturnForSell($ticker, $dateFrom, $dateTo)
    {
        return $this->calculateTotalReturn($ticker, $dateFrom, $dateTo, 'sell');
    }
    
    private function calculateTotalReturnByAnalystAndTicker(Entity\Analyst $analyst, $ticker){
        $analyses = $this->analysisService->getAllByAnalystAndTickerAscending($analyst, $ticker);
        $totalReturn = 0;
        if(!empty($analyses)){
            $prevRecommendation = $this->raetingHelper->getAnalysisStatus($analyses[0]->getRecommendation());
            $dateFrom = $analyses[0]->getDate();
            foreach($analyses as $analysis){
                $recommendation = $this->raetingHelper->getAnalysisStatus($analysis->getRecommendation());
                $dateTo = $analysis->getDate();
                if($recommendation != $prevRecommendation){
                    if($prevRecommendation == Entity\Analysis::RECOMMENDATION_BUY && $recommendation == Entity\Analysis::RECOMMENDATION_HOLD){
                        $totalReturn += $this->calculateTotalReturnForBuy($ticker, $dateFrom, $dateTo);
                    }elseif($prevRecommendation == Entity\Analysis::RECOMMENDATION_BUY && $recommendation == Entity\Analysis::RECOMMENDATION_SELL){
                        $totalReturn += $this->calculateTotalReturnForBuy($ticker, $dateFrom, $dateTo);
                        $dateFrom = $analysis->getDate();
                    }elseif($prevRecommendation == Entity\Analysis::RECOMMENDATION_SELL && $recommendation == Entity\Analysis::RECOMMENDATION_HOLD){
                        $totalReturn += $this->calculateTotalReturnForSell($ticker, $dateFrom, $dateTo);
                    }elseif($prevRecommendation == Entity\Analysis::RECOMMENDATION_SELL && $recommendation == Entity\Analysis::RECOMMENDATION_BUY){
                        $totalReturn += $this->calculateTotalReturnForSell($ticker, $dateFrom, $dateTo);
                        $dateFrom = $analysis->getDate();
                    }elseif($prevRecommendation == Entity\Analysis::RECOMMENDATION_HOLD){
                        $dateFrom = $analysis->getDate();
                    }
                }
                $prevRecommendation = $recommendation;
            }
        }
        return $totalReturn;
    }
    
    
    public function calculateTotalReturnByAnalyst(Entity\Analyst $analyst)
    {
        $tickers = $this->analysisService->getAnalystTickers($analyst);
        $return = array();
        if(!empty($tickers)){
            foreach($tickers as $ticker){
                $return[$ticker['id']] = $this->calculateTotalReturnByAnalystAndTicker($analyst, $ticker['symbol']);
            }
        }
        return $return;
    }
    
    private function saveRating($analystId, $tickerId, $value)
    {
        $query = 'INSERT INTO total_return (analyst_id, ticker_id, value) values('.$analystId.', '.$tickerId.', '.$value.') 
            ON DUPLICATE KEY UPDATE value = values(value)';
        
        $conn = $this->em->getConnection();
        $conn->exec($query);
    }
    
    public function saveRatings($ratingArr)
    {
        if(!empty($ratingArr)){
            foreach($ratingArr as $analystId => $analystRatings){
                if(!empty($analystRatings)){
                    foreach($analystRatings as $tickerId => $value){
                        $this->saveRating($analystId, $tickerId, $value);
                    }
                }
            }
        }
    }
    
    private function getAllSortedByTotalReturn($sort)
    {
        return $this->getRepository()->getAllSortedByTotalReturn($sort);
    }
    
    public function updateRanks()
    {
        $analysts = $this->getAllSortedByTotalReturn('desc');
        $i = 1;
        if(!empty($analysts)){
            foreach($analysts as $analyst){
                $analyst->setRank($i);
                $this->save($analyst);
                $i++;
            }
        }
    }
}

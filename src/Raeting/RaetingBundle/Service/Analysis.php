<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

use Raeting\RaetingBundle\Service\SymbolService;

class Analysis
{

    public function __construct(EntityManager $em, Symbol $symbolService)
    {
        $this->em = $em;
        $this->symbolService = $symbolService;
    }

    public function getNew()
    {
        return new Entity\Analysis();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\Analysis $entity)
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

    /**
     * @return Entity\AnalysisRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('RaetingRaetingBundle:Analysis');
    }

    public function getAllByAnalyst($analyst, $perPage, $page)
    {
        return $this->getRepository()->getAllByAnalyst($analyst, $perPage, $page);
    }

    public function getAllByTickerWithPaging($ticker, $perPage, $page)
    {
        return $this->getRepository()->getAllByTickerWithPaging($ticker, $perPage, $page);
    }

    public function getAllByTickerWithPagingByQuery($ticker, $perPage, $page, $query)
    {
        return $this->getRepository()->getAllByTickerWithPagingByQuery($ticker, $perPage, $page, $query);
    }

    public function getAllByQuery($query, $perPage, $page)
    {
        return $this->getRepository()->getAllByQuery($query, $perPage, $page);
    }

    public function getAllWithPaging($perPage, $page)
    {
        return $this->getRepository()->getAllWithPaging($perPage, $page);
    }

    public function getAllByAnalystAndTicker($analyst, $ticker, $perPage = null, $page = null)
    {
        return $this->getRepository()->getAllByAnalystAndTicker($analyst, $ticker, $perPage, $page);
    }

    public function getAllByAnalystAndTickerAscending($analyst, $ticker, $perPage = null, $page = null)
    {
        return $this->getRepository()->getAllByAnalystAndTicker($analyst, $ticker, $perPage, $page, 'asc');
    }

    public function getAllByAnalystAndTickerForGraph($analyst, $ticker)
    {
        return $this->getRepository()->getAllByAnalystAndTickerForGraph($analyst, $ticker);
    }

    public function getAnalystEstimationRangeByTicker($analyst, $ticker)
    {
        return $this->getRepository()->getAnalystEstimationRangeByTicker($analyst, $ticker);
    }

    public function getAllByAnalystAndQuery($analyst, $query, $perPage, $page)
    {
        return $this->getRepository()->getAllByAnalystAndQuery($analyst, $query, $perPage, $page);
    }

    public function countAllByAnalyst($analyst)
    {
        return $this->getRepository()->countAllByAnalyst($analyst);
    }

    public function countAll()
    {
        return $this->getRepository()->countAll();
    }

    public function countAllByAnalystAndQuery($analyst, $query)
    {
        return $this->getRepository()->countAllByAnalystAndQuery($analyst, $query);
    }

    public function countAllByQuery($query)
    {
        return $this->getRepository()->countAllByQuery($query);
    }

    public function countAllByTicker($ticker)
    {
        return $this->getRepository()->countAllByTicker($ticker);
    }

    public function countAllByTickerAndQuery($ticker, $query)
    {
        return $this->getRepository()->countAllByTickerAndQuery($ticker, $query);
    }

    private function formatRecommendation($recommendation)
    {
        if ($recommendation == 'overweight') {
            $recommendation = Entity\Analysis::RECOMMENDATION_BUY;
        } elseif ($recommendation == 'overwt/neutral') {
            $recommendation = Entity\Analysis::RECOMMENDATION_BUY;
        } elseif ($recommendation == 'overwt/positive') {
            $recommendation = Entity\Analysis::RECOMMENDATION_BUY;
        }

        $valid = array(
            Entity\Analysis::RECOMMENDATION_BUY,
            Entity\Analysis::RECOMMENDATION_HOLD,
            Entity\Analysis::RECOMMENDATION_SELL
        );

        if (in_array($recommendation, $valid)) {
            return $recommendation;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function insertData($symbol, $analyst, $data)
    {
        $result = false;
        if (!empty($analyst) && !empty($symbol)) {

            $conn = $this->em->getConnection();

            $query =
                "INSERT INTO `analysis` (
                    `ticker_id`, `analyst_id`, `estimation`, `date`, `period`, `recommendation`)
                 VALUES (
                    :tickerId, :analystId, :estimation, :date, :period, :recommendation)
                 ON DUPLICATE KEY UPDATE
                   `estimation` = :estimation,
                   `period` = :period,
                   `recommendation` = :recommendation";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(":tickerId", $symbol->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(":analystId", $analyst->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(":estimation", $data['estimation']);
            $stmt->bindValue(":date", $data['date']);
            $stmt->bindValue(":period", $data['period'], \PDO::PARAM_INT);
            $stmt->bindValue(":recommendation", $data['recommendation']);
            $result = $stmt->execute();
        }

        return $result;
    }

    public function getLastDateByAnalyst($analyst)
    {
        return $this->getRepository()->getLastDateByAnalyst($analyst);
    }

    public function getLastSymbolsByAnalyst($analyst, $amount)
    {
        return $this->getRepository()->getLastSymbolsByAnalyst($analyst, $amount);
    }

    public function getAnalystTickers($analyst)
    {
        return $this->getRepository()->getAnalystTickers($analyst);
    }

    public function getLatest()
    {
        return $this->getRepository()->getLatest();
    }
}

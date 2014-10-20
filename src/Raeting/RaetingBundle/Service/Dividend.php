<?php

namespace Raeting\RaetingBundle\Service;

use Doctrine\ORM\EntityManager;
use Raeting\RaetingBundle\Entity;

class Dividend
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNew()
    {
        return new Entity\Dividend();
    }

    public function get($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function save(Entity\Dividend $entity)
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
        return $this->em->getRepository('RaetingRaetingBundle:Dividend');
    }

    public function getSumByInterval($ticker, $dateFrom, $dateTo)
    {
        return $this->getRepository()->getSumByInterval($ticker, $dateFrom, $dateTo);
    }

    /**
     * @return int
     */
    public function import($data)
    {
        $result = 0;
        $conn = $this->em->getConnection();
        $query =
                "INSERT INTO `dividend` (`ticker_id`, `date`, `amount`)
                 VALUES (:tickerId, :date, :amount)
                 ON DUPLICATE KEY UPDATE
                   `amount` = :amount";

        $stmt = $conn->prepare($query);

        foreach ($data as $row) {
            $stmt->bindValue(":tickerId", $row['ticker_id'], \PDO::PARAM_INT);
            $stmt->bindValue(":date", $row['date']);
            $stmt->bindValue(":amount", $row['amount']);
            $result += (bool) $stmt->execute();
        }

        return $result;
    }
}

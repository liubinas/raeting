<?php

namespace Raeting\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user_stats")
 * @ORM\Entity(repositoryClass="Raeting\UserBundle\Entity\UserStats")
 */
class UserStats
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userid;
    
    /**
     * @var float
     *
     * @ORM\Column(name="profit", type="decimal", nullable=false, scale=6)
     */
    private $profit;
    
    /**
     * @var float
     *
     * @ORM\Column(name="pips", type="decimal", nullable=false, scale=6)
     */
    private $pips;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="total_signals", type="integer", nullable=false, scale=6)
     */
    private $totalSignals;
    
    /**
     * @var date
     *
     * @ORM\Column(name="date_created", type="date", nullable=false)
     */
    private $dateCreated;
    

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getUserid() {
        return $this->userid;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
    }

    public function getProfit() {
        return $this->profit;
    }

    public function setProfit($profit) {
        $this->profit = $profit;
    }

    public function getPips() {
        return $this->pips;
    }

    public function setPips($pips) {
        $this->pips = $pips;
    }
    
    public function getTotalSignals() {
        return $this->totalSignals;
    }

    public function setTotalSignals($totalSignals) {
        $this->totalSignals = $totalSignals;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
    }
}
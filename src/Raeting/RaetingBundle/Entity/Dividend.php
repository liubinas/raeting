<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Symbol
 *
 * @ORM\Table(name="dividend")
 * @ORM\Entity
 */
class Dividend
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="decimal", nullable=false, scale=6)
     */
    private $amount;

    /**
     * @var \Raeting\RaetingBundle\Entity\Symbol
     *
     * @ORM\ManyToOne(targetEntity="Raeting\RaetingBundle\Entity\Symbol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ticker_id", referencedColumnName="id")
     * })
     */
    private $ticker;
    
    /**
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Dividend
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime  
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Set amount
     *
     * @param float $amount
     * @return Dividend
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set ticker
     *
     * @param \Raeting\RaetingBundle\Entity\Symbol $ticker
     * @return Dividend
     */
    public function setTicker(\Raeting\RaetingBundle\Entity\Symbol $ticker = null)
    {
        $this->ticker = $ticker;

        return $this;
    }

    /**
     * Get ticker
     *
     * @return \Raeting\RaetingBundle\Entity\Symbol
     */
    public function getTicker()
    {
        return $this->ticker;
    }
}
<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurrencyRate
 */
class CurrencyRate
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $bid;

    /**
     * @var string
     */
    private $ask;
    
    /**
     * @var string
     */
    private $high;
    
    /**
     * @var string
     */
    private $low;

    /**
     * @var \DateTime
     */
    private $created;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="source_time", type="timestamp", nullable=false)
     */
    private $sourceTime;

    /**
     * @var \Raeting\RaetingBundle\Entity\Symbol
     */
    private $currency;


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
     * Set bid
     *
     * @param string $bid
     * @return CurrencyRate
     */
    public function setBid($bid)
    {
        $this->bid = $bid;
    
        return $this;
    }

    /**
     * Get bid
     *
     * @return string 
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * Set ask
     *
     * @param string $ask
     * @return CurrencyRate
     */
    public function setAsk($ask)
    {
        $this->ask = $ask;
    
        return $this;
    }

    /**
     * Get ask
     *
     * @return string 
     */
    public function getAsk()
    {
        return $this->ask;
    }
    
    /**
     * Set high
     *
     * @param string $high
     * @return CurrencyRate
     */
    public function setHigh($high)
    {
        $this->high = $high;
    
        return $this;
    }

    /**
     * Get high
     *
     * @return string 
     */
    public function getHigh()
    {
        return $this->high;
    }
    
    /**
     * Set low
     *
     * @param string $low
     * @return CurrencyRate
     */
    public function setLow($low)
    {
        $this->low = $low;
    
        return $this;
    }

    /**
     * Get low
     *
     * @return string 
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CurrencyRate
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * Set sourceTime
     *
     * @param \DateTime $sourceTime
     * @return CurrencyRate
     */
    public function setSourceTime($sourceTime)
    {
        $this->sourceTime = $sourceTime;
    
        return $this;
    }

    /**
     * Get sourceTime
     *
     * @return \DateTime 
     */
    public function getSourceTime()
    {
        return $this->sourceTime;
    }

    /**
     * Set currency
     *
     * @param \Raeting\RaetingBundle\Entity\Symbol $currency
     * @return CurrencyRate
     */
    public function setCurrency(\Raeting\RaetingBundle\Entity\Symbol $currency = null)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return \Raeting\RaetingBundle\Entity\Symbol 
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}

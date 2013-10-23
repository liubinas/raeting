<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TickerRate
 */
class TickerRate
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
    private $ticker;


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
     * @return TickerRate
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
     * @return TickerRate
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
     * @return TickerRate
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
     * @return TickerRate
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
     * @return TickerRate
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
     * @return TickerRate
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
     * Set ticker
     *
     * @param \Raeting\RaetingBundle\Entity\Symbol $ticker
     * @return TickerRate
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

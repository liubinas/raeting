<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rate
 */
class Rate
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
     * @ORM\Column(name="source_time", type="datetime", nullable=false)
     */
    private $sourceTime;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="source_time", type="date", nullable=false)
     */
    private $sourceDate;

    /**
     * @var \Raeting\RaetingBundle\Entity\Symbol
     */
    private $symbol;


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
     * @return Rate
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
     * @return Rate
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
     * @return Rate
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
     * @return Rate
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
     * @return Rate
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
     * @return Rate
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
     * Set sourceDate
     *
     * @param \DateTime $sourceDate
     * @return Rate
     */
    public function setSourceDate($sourceDate)
    {
        $this->sourceDate = $sourceDate;
    
        return $this;
    }

    /**
     * Get sourceDate
     *
     * @return \DateTime 
     */
    public function getSourceDate()
    {
        return $this->sourceDate;
    }

    /**
     * Set symbol
     *
     * @param \Raeting\RaetingBundle\Entity\Symbol $symbol
     * @return Rate
     */
    public function setSymbol(\Raeting\RaetingBundle\Entity\Symbol $symbol = null)
    {
        $this->symbol = $symbol;
    
        return $this;
    }

    /**
     * Get symbol
     *
     * @return \Raeting\RaetingBundle\Entity\Symbol 
     */
    public function getSymbol()
    {
        return $this->symbol;
    }
}

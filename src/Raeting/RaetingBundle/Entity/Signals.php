<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signals
 *
 * @ORM\Table(name="signals")
 * @ORM\Entity
 */
class Signals
{
    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=13, nullable=false)
     */
    private $uuid;

    /**
     * @var integer
     *
     * @ORM\Column(name="quote_id", type="integer", nullable=false)
     */
    private $quoteId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="buy", type="boolean", nullable=false)
     */
    private $buy;

    /**
     * @var float
     *
     * @ORM\Column(name="open", type="decimal", nullable=false)
     */
    private $open;

    /**
     * @var float
     *
     * @ORM\Column(name="take_profit", type="decimal", nullable=false)
     */
    private $takeProfit;

    /**
     * @var float
     *
     * @ORM\Column(name="stop_loss", type="decimal", nullable=false)
     */
    private $stopLoss;

    /**
     * @var float
     *
     * @ORM\Column(name="close", type="decimal", nullable=false)
     */
    private $close;

    /**
     * @var float
     *
     * @ORM\Column(name="profit", type="decimal", nullable=false)
     */
    private $profit;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="opened", type="datetime", nullable=false)
     */
    private $opened;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="open_expire", type="datetime", nullable=false)
     */
    private $openExpire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closed", type="datetime", nullable=false)
     */
    private $closed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="close_expire", type="datetime", nullable=false)
     */
    private $closeExpire;

    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=false)
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set uuid
     *
     * @param string $uuid
     * @return Signals
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    
        return $this;
    }

    /**
     * Get uuid
     *
     * @return string 
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set quoteId
     *
     * @param integer $quoteId
     * @return Signals
     */
    public function setQuoteId($quoteId)
    {
        $this->quoteId = $quoteId;
    
        return $this;
    }

    /**
     * Get quoteId
     *
     * @return integer 
     */
    public function getQuoteId()
    {
        return $this->quoteId;
    }

    /**
     * Set buy
     *
     * @param boolean $buy
     * @return Signals
     */
    public function setBuy($buy)
    {
        $this->buy = $buy;
    
        return $this;
    }

    /**
     * Get buy
     *
     * @return boolean 
     */
    public function getBuy()
    {
        return $this->buy;
    }

    /**
     * Set open
     *
     * @param float $open
     * @return Signals
     */
    public function setOpen($open)
    {
        $this->open = $open;
    
        return $this;
    }

    /**
     * Get open
     *
     * @return float 
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set takeProfit
     *
     * @param float $takeProfit
     * @return Signals
     */
    public function setTakeProfit($takeProfit)
    {
        $this->takeProfit = $takeProfit;
    
        return $this;
    }

    /**
     * Get takeProfit
     *
     * @return float 
     */
    public function getTakeProfit()
    {
        return $this->takeProfit;
    }

    /**
     * Set stopLoss
     *
     * @param float $stopLoss
     * @return Signals
     */
    public function setStopLoss($stopLoss)
    {
        $this->stopLoss = $stopLoss;
    
        return $this;
    }

    /**
     * Get stopLoss
     *
     * @return float 
     */
    public function getStopLoss()
    {
        return $this->stopLoss;
    }

    /**
     * Set close
     *
     * @param float $close
     * @return Signals
     */
    public function setClose($close)
    {
        $this->close = $close;
    
        return $this;
    }

    /**
     * Get close
     *
     * @return float 
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * Set profit
     *
     * @param float $profit
     * @return Signals
     */
    public function setProfit($profit)
    {
        $this->profit = $profit;
    
        return $this;
    }

    /**
     * Get profit
     *
     * @return float 
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Signals
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Signals
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Signals
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
     * Set opened
     *
     * @param \DateTime $opened
     * @return Signals
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;
    
        return $this;
    }

    /**
     * Get opened
     *
     * @return \DateTime 
     */
    public function getOpened()
    {
        return $this->opened;
    }

    /**
     * Set openExpire
     *
     * @param \DateTime $openExpire
     * @return Signals
     */
    public function setOpenExpire($openExpire)
    {
        $this->openExpire = $openExpire;
    
        return $this;
    }

    /**
     * Get openExpire
     *
     * @return \DateTime 
     */
    public function getOpenExpire()
    {
        return $this->openExpire;
    }

    /**
     * Set closed
     *
     * @param \DateTime $closed
     * @return Signals
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    
        return $this;
    }

    /**
     * Get closed
     *
     * @return \DateTime 
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set closeExpire
     *
     * @param \DateTime $closeExpire
     * @return Signals
     */
    public function setCloseExpire($closeExpire)
    {
        $this->closeExpire = $closeExpire;
    
        return $this;
    }

    /**
     * Get closeExpire
     *
     * @return \DateTime 
     */
    public function getCloseExpire()
    {
        return $this->closeExpire;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return Signals
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
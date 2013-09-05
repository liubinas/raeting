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
    
    const STATUS_NEW = 'new';
    const STATUS_OPENED = 'opened';
    const STATUS_CLOSED = 'closed';
    const STATUS_ERROR = 'error';
    
    protected $buyEnum = array(
        '0'    => 'Buy',
        '1'    => 'Sell',
    );
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=13, nullable=false)
     */
    private $uuid;

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
    private $profit = 0;

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
    private $status = self::STATUS_NEW;

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
     * @var \Raeting\RaetingBundle\Entity\Quote
     *
     * @ORM\ManyToOne(targetEntity="Raeting\RaetingBundle\Entity\Quote")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quote_id", referencedColumnName="id")
     * })
     */
    protected $quote;
    /**
     * @var \Raeting\RaetingBundle\Entity\Ticker
     *
     * @ORM\ManyToOne(targetEntity="Raeting\RaetingBundle\Entity\Ticker")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ticker_id", referencedColumnName="id")
     * })
     */
    private $ticker;

    /**
     * @var \Raeting\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Raeting\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;



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
     * Set quote
     *
     * @param \Raeting\RaetingBundle\Entity\Quote $quote
     * @return Signals
     */
    public function setQuote(\Raeting\RaetingBundle\Entity\Quote $quote = null)
    {
        $this->quote = $quote;
    
        return $this;
    }

    /**
     * Get quote
     *
     * @return \Raeting\RaetingBundle\Entity\Quote 
     */
    public function getQuote()
    {
        return $this->quote;
    }
    /**
     * Set ticker
     *
     * @param \Raeting\RaetingBundle\Entity\Ticker $ticker
     * @return Signals
     */
    public function setTicker(\Raeting\RaetingBundle\Entity\Ticker $ticker= null)
    {
        $this->ticker = $ticker;

        return $this;
    }

    /**
     * Get ticker
     *
     * @return \Raeting\RaetingBundle\Entity\Ticker
     */
    public function getTicker()
    {
        return $this->ticker;
    }

    /**
     * Set user
     *
     * @param \Raeting\UserBundle\Entity\User $user
     * @return Signals
     */
    public function setUser(\Raeting\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Raeting\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    public function getBuyValue()
    {
        return $this->buyEnum[$this->buy];
    }
}
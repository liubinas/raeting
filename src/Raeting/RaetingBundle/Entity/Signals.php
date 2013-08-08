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
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="quote", type="text", nullable=false)
     */
    private $quote;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="open", type="text", nullable=false)
     */
    private $open;

    /**
     * @var string
     *
     * @ORM\Column(name="profit", type="text", nullable=false)
     */
    private $profit;

    /**
     * @var string
     *
     * @ORM\Column(name="loss", type="text", nullable=false)
     */
    private $loss;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



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
     * Set status
     *
     * @param string $status
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
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set quote
     *
     * @param string $quote
     * @return Signals
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;
    
        return $this;
    }

    /**
     * Get quote
     *
     * @return string 
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Signals
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set open
     *
     * @param string $open
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
     * @return string 
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set profit
     *
     * @param string $profit
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
     * @return string 
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * Set loss
     *
     * @param string $loss
     * @return Signals
     */
    public function setLoss($loss)
    {
        $this->loss = $loss;
    
        return $this;
    }

    /**
     * Get loss
     *
     * @return string 
     */
    public function getLoss()
    {
        return $this->loss;
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
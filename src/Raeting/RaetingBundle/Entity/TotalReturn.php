<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TotalReturn
 */
class TotalReturn
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var \Raeting\RaetingBundle\Entity\Symbol
     */
    private $ticker;

    /**
     * @var \Raeting\RaetingBundle\Entity\Analyst
     */
    private $analyst;


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
     * Set value
     *
     * @param string $value
     * @return TotalReturn
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return TotalReturn
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set ticker
     *
     * @param \Raeting\RaetingBundle\Entity\Symbol $ticker
     * @return TotalReturn
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

    /**
     * Set analyst
     *
     * @param \Raeting\RaetingBundle\Entity\Analyst $analyst
     * @return TotalReturn
     */
    public function setAnalyst(\Raeting\RaetingBundle\Entity\Analyst $analyst = null)
    {
        $this->analyst = $analyst;
    
        return $this;
    }

    /**
     * Get analyst
     *
     * @return \Raeting\RaetingBundle\Entity\Analyst 
     */
    public function getAnalyst()
    {
        return $this->analyst;
    }
}
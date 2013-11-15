<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnalystTotalReturn
 */
class AnalystTotalReturn
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
     * @return AnalystTotalReturn
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
     * Set analyst
     *
     * @param \Raeting\RaetingBundle\Entity\Analyst $analyst
     * @return AnalystTotalReturn
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

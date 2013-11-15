<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Benchmark
 */
class Benchmark
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var \Raeting\RaetingBundle\Entity\Symbol
     */
    private $ticker;


    /**
     * Set value
     *
     * @param string $value
     * @return Benchmark
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
     * Set ticker
     *
     * @param \Raeting\RaetingBundle\Entity\Symbol $ticker
     * @return Benchmark
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
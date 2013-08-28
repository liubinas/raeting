<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticker
 */
class Ticker
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $symbol;

    /**
     * @var string
     */
    private $name;


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
     * Set symbol
     *
     * @param string $symbol
     * @return Ticker
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    
        return $this;
    }

    /**
     * Get symbol
     *
     * @return string 
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Ticker
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}

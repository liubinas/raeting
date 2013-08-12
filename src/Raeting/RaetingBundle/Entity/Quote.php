<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity
 */
class Quote
{
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
     * @ORM\Column(name="symbol", type="string", length=20, nullable=false)
     */
    private $symbol;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \Raeting\RaetingBundle\Entity\Market
     *
     * @ORM\ManyToOne(targetEntity="Raeting\RaetingBundle\Entity\Market")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="market_id", referencedColumnName="id")
     * })
     */
    private $market;



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
     * @return Quote
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
     * Set title
     *
     * @param string $title
     * @return Quote
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set market
     *
     * @param \Raeting\RaetingBundle\Entity\Market $market
     * @return Quote
     */
    public function setMarket(\Raeting\RaetingBundle\Entity\Market $market = null)
    {
        $this->market = $market;
    
        return $this;
    }

    /**
     * Get market
     *
     * @return \Raeting\RaetingBundle\Entity\Market 
     */
    public function getMarket()
    {
        return $this->market;
    }
}
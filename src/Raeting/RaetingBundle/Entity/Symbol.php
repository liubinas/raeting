<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Symbol
 *
 * @ORM\Table(name="symbol")
 * @ORM\Entity
 */
class Symbol
{
    const TYPE_QUOTE = 'quote';
    const TYPE_TICKER = 'ticker';
    
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
     * @var integer
     *
     * @ORM\Column(name="pips_position", type="string", length=255, nullable=false)
     */
    private $pipsPosition;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    private $type = self::TYPE_QUOTE;


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
     * @return Symbol
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
     * Set pipsPosition
     *
     * @param string $pipsPosition
     * @return Symbol
     */
    public function setPipsPosition($pipsPosition)
    {
        $this->pipsPosition = $pipsPosition;
    
        return $this;
    }

    /**
     * Get symbol
     *
     * @return string 
     */
    public function getPipsPosition()
    {
        return $this->pipsPosition;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Symbol
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
     * Set type
     *
     * @param string $type
     * @return Symbol
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
     * Set market
     *
     * @param \Raeting\RaetingBundle\Entity\Market $market
     * @return Symbol
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
    /*
     * __toString
     *
     * @return String
     */
    public function __toString()
    {
        return $this->getSymbol();
    }
}
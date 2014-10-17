<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Symbol
 *
 * @ORM\Table(name="analysis")
 * @ORM\Entity
 */
class Analysis
{
    const RECOMMENDATION_BUY = 'buy';
    const RECOMMENDATION_HOLD = 'hold';
    const RECOMMENDATION_SELL = 'sell';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Raeting\RaetingBundle\Entity\Symbol
     *
     * @ORM\ManyToOne(targetEntity="Raeting\RaetingBundle\Entity\Symbol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ticker_id", referencedColumnName="id")
     * })
     */
    private $ticker;

    /**
     * @var \Raeting\RaetingBundle\Entity\Analyst
     *
     * @ORM\ManyToOne(targetEntity="Raeting\RaetingBundle\Entity\Analyst")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="analyst_id", referencedColumnName="id")
     * })
     */
    private $analyst;

    /**
     * @var string
     *
     * @ORM\Column(name="estimation", type="string")
     */
    private $estimation;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="period", type="string")
     */
    private $period;

    /**
     * @var recommendation
     *
     * @ORM\Column(name="recommendation", type="string")
     */
    private $recommendation;

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
     * Set ticker
     *
     * @param \Raeting\RaetingBundle\Entity\Symbol $symbol
     * @return Analysis
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
     * @return Analysis
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

    /**
     * Set estimation
     *
     * @param string $estimation
     * @return Analysis
     */
    public function setEstimation($estimation)
    {
        $this->estimation = $estimation;

        return $this;
    }

    /**
     * Get estimation
     *
     * @return string
     */
    public function getEstimation()
    {
        return $this->estimation;
    }
    /**
     * Set date
     *
     * @param string $date
     * @return Analysis
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set period
     *
     * @param string $period
     * @return Analysis
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set recommendation
     *
     * @param string $recommendation
     * @return Analysis
     */
    public function setRecommendation($recommendation)
    {
        $this->recommendation = $recommendation;

        return $this;
    }

    /**
     * Get recommendation
     *
     * @return string
     */
    public function getRecommendation()
    {
        return $this->recommendation;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
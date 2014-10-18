<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TotalReturn
 *
 * @ORM\Table(
 *  name="total_return",
 *  uniqueConstraints={@ORM\UniqueConstraint(name="ticker_analyst", columns={"ticker_id", "analyst_id"})}
 * )
 */
class TotalReturn
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
     * @var float
     *
     * @ORM\Column(name="value", type="decimal", precision=12, scale=6)
     */
    private $value;

    /**
     * @var \Raeting\RaetingBundle\Entity\Symbol
     *
     * @ORM\ManyToOne(targetEntity="Raeting\RaetingBundle\Entity\Symbol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ticker_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $ticker;

    /**
     * @var \Raeting\RaetingBundle\Entity\Analyst
     *
     * @ORM\ManyToOne(targetEntity="Raeting\RaetingBundle\Entity\Analyst")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="analyst_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $analyst;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $updated;


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
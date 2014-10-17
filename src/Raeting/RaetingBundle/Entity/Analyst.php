<?php

namespace Raeting\RaetingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Symbol
 *
 * @ORM\Table(name="analyst")
 * @ORM\Entity(repositoryClass="Raeting\RaetingBundle\Entity\AnalystRepository")
 */
class Analyst
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=false)
     */
    private $company;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $rank;

    /**
     * @var float
     *
     * @ORM\Column(name="total_return", type="decimal", precision=12, scale=6)
     */
    private $totalReturn;

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
     * Set name
     *
     * @param string $name
     * @return Analyst
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

    /**
     * Set company
     *
     * @param string $company
     * @return Analyst
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Analyst
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return Analyst
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set total return
     *
     * @param float $totalReturn
     * @return Analyst
     */
    public function setTotalReturn($totalReturn)
    {
        $this->totalReturn = $totalReturn;

        return $this;
    }

    /**
     * Get total return
     *
     * @return float
     */
    public function getTotalReturn()
    {
        return $this->totalReturn;
    }


}
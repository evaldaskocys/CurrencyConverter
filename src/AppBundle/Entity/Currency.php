<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Currency
 *
 * @ORM\Table(name="currency", indexes={@ORM\Index(name="currencyIndex", columns={"currency"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CurrencyRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Currency
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="source_id", type="integer")
     */
    protected $sourceId;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float")
     */
    protected $rate;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3)
     */
    protected $currency;

    /**
     * @ORM\ManyToOne(targetEntity="Source", inversedBy="currencies")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     */
    protected $source;

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
     * Set sourceId
     *
     * @param integer $sourceId
     * @return Currency
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Get sourceId
     *
     * @return integer 
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Set rate
     *
     * @param float $rate
     * @return Currency
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    public function __toString()
    {
        return $this->getCurrency();
    }

    /**
     * Set source
     *
     * @param \AppBundle\Entity\Source $source
     * @return Currency
     */
    public function setSource(\AppBundle\Entity\Source $source = null)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return \AppBundle\Entity\Source 
     */
    public function getSource()
    {
        return $this->source;
    }
}

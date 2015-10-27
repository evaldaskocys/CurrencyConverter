<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Source.
 *
 * @ORM\Table(name="source")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Source
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="short_code", type="string", length=3)
     */
    protected $shortCode;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     */
    protected $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date")
     */
    protected $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Currency", mappedBy="source")
     */
    protected $currencies;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set shortCode.
     *
     * @param string $shortCode
     *
     * @return Source
     */
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * Get shortCode.
     *
     * @return string
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Source
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set createdAt.
     *
     * @return Source
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->currencies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add currencies.
     *
     * @param \AppBundle\Entity\Currency $currencies
     *
     * @return Source
     */
    public function addCurrency(\AppBundle\Entity\Currency $currencies)
    {
        $this->currencies[] = $currencies;

        return $this;
    }

    /**
     * Remove currencies.
     *
     * @param \AppBundle\Entity\Currency $currencies
     */
    public function removeCurrency(\AppBundle\Entity\Currency $currencies)
    {
        $this->currencies->removeElement($currencies);
    }

    /**
     * Get currencies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }
}

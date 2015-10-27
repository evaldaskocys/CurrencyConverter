<?php

namespace AppBundle\Services;

use AppBundle\Utils\ECBCrawlerStrategy;

class Crawler
{
    protected $crawlerStrategy;

    /**
     * @param ECBCrawlerStrategy $crawlerStrategy
     */
    public function __construct(ECBCrawlerStrategy $crawlerStrategy)
    {
        $this->crawlerStrategy = $crawlerStrategy;
    }

    /**
     * @return mixed
     */
    public function getRates()
    {
        return $this->crawlerStrategy->getElements();
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->crawlerStrategy->getShortName();
    }

    /**
     * @return string
     */
    public function getLongName()
    {
        return $this->crawlerStrategy->getLongName();
    }

    /**
     * @return string
     */
    public function getRemoteUrl()
    {
        return $this->crawlerStrategy->getRemoteUrl();
    }

    /**
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->crawlerStrategy->getBaseCurrency();
    }
}

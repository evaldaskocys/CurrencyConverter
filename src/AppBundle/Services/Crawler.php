<?php

namespace AppBundle\Services;


use AppBundle\Utils\ECBCrawlerStrategy;

class Crawler {

    private $crawlerStrategy;

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
}
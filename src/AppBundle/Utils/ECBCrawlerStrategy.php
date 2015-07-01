<?php

namespace AppBundle\Utils;

class ECBCrawlerStrategy implements SourceCrawlerInterface
{
    const URL = "http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
    const SHORT_NAME = "ECB";
    const LONG_NAME = "European central bank";
    const DECIMAL = 2;

    public function getShortName()
    {
        return self::SHORT_NAME;
    }

    public function getRemoteUrl()
    {
        return self::URL;
    }

    public function getLongName()
    {
        return self::LONG_NAME;
    }

    public function getDecimal()
    {
        return self::DECIMAL;
    }

    public function getElements()
    {
        $content = simplexml_load_file(self::URL);
        return $content->Cube->Cube->Cube;
    }
}
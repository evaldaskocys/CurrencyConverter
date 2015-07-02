<?php

namespace AppBundle\Utils;

class ECBCrawlerStrategy implements SourceCrawlerInterface
{
    const URL = "http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
    const SHORT_NAME = "ECB";
    const LONG_NAME = "European central bank";
    const DECIMAL = 2;
    const POINT = ".";
    const THOUSANDS_SEP = "";

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

    public function getPoint()
    {
        return self::POINT;
    }

    public function getThousandsSep()
    {
        return self::THOUSANDS_SEP;
    }

    public function getRoundMode()
    {
        return PHP_ROUND_HALF_UP;
    }

    public function getElements()
    {
        $content = simplexml_load_file(self::URL);
        return $content->Cube->Cube->Cube;
    }
}
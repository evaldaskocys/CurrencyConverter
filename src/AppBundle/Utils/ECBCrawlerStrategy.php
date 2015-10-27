<?php

namespace AppBundle\Utils;

class ECBCrawlerStrategy implements SourceCrawlerInterface
{
    const URL = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    const BASE_CURRENCY = 'EUR';
    const SHORT_NAME = 'ECB';
    const LONG_NAME = 'European central bank';

    public function getShortName()
    {
        return self::SHORT_NAME;
    }

    public function getBaseCurrency()
    {
        return self::BASE_CURRENCY;
    }

    public function getRemoteUrl()
    {
        return self::URL;
    }

    public function getLongName()
    {
        return self::LONG_NAME;
    }

    public function getElements()
    {
        $content = simplexml_load_file(self::URL);

        return $content->Cube->Cube->Cube;
    }
}

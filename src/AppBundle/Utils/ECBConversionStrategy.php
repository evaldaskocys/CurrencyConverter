<?php

namespace AppBundle\Utils;

class ECBConversionStrategy implements SourceConversionInterface
{
    const SHORT_NAME = "ECB";
    const DECIMAL = 2;
    const POINT = ".";
    const THOUSANDS_SEP = "";
    const ROUND = PHP_ROUND_HALF_UP;

    public function getShortName()
    {
        return self::SHORT_NAME;
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
        return self::ROUND;
    }
}
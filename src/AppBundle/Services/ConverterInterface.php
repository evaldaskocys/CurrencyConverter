<?php

namespace AppBundle\Services;

interface ConverterInterface
{
    public function convert($date, $amount, $currencyCodeFrom, $currencyCodeTo);
}

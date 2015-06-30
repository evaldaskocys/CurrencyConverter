<?php

namespace AppBundle\Utils;


class Converter {

    private $source;
    private $result;

    /**
     * Inject rates source
     *
     * @param SourceInterface $source
     */
    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    /**
     * Convert
     *
     * @param $amount
     * @param $currencyFrom
     * @param $currencyTo
     */
    public function convert($amount, $currencyFrom, $currencyTo)
    {

    }

    /**
     * Return conversion result
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
} 
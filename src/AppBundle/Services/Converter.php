<?php

namespace AppBundle\Services;

use AppBundle\Utils\SourceConversionInterface;
use AppBundle\Utils\SourceCrawlerInterface;
use Doctrine\ORM\EntityManager;


class Converter {

    private $conversion;
    private $em;

    /**
     *
     * @param SourceCrawlerInterface $conversion
     * @param EntityManager $entityManager
     */
    public function __construct(SourceCrawlerInterface $conversion, EntityManager $entityManager)
    {
        $this->conversion = $conversion;
        $this->em = $entityManager;
    }

    /**
     * @param $date
     * @param $amount
     * @param $currencyFrom
     * @param $currencyTo
     * @return string
     */
    public function convert($date, $amount, $currencyFrom, $currencyTo)
    {
        $currencyFrom = $this->getCurrencyRateBySourceAndDate($currencyFrom, $date);
        $currencyTo= $this->getCurrencyRateBySourceAndDate($currencyTo, $date);

        return $this->makeConversion($amount, $currencyFrom->getRate(), $currencyTo->getRate());
    }

    /**
     * Returns currency rate by provided currency code and date
     *
     * @param $currency
     * @param $date
     * @return int|mixed
     */
    private function getCurrencyRateBySourceAndDate($currency, $date)
    {
        if ($currency == "EUR"){
            return 1;
        }
        return $this->em->getRepository('AppBundle:Currency')->findRateByDateAndShortNameAndCurrency($date, $this->conversion->getShortName(), $currency);
    }

    /**
     * Returns zeros formatted by conversion rules
     *
     * @return string
     */
    public function getFormattedZeros()
    {
        return number_format(0, $this->conversion->getDecimal(), $this->conversion->getPoint(), $this->conversion->getThousandsSep());
    }

    /**
     * Makes the conversion of provided amount from one rate to other
     *
     * @param $amount
     * @param $rateFrom
     * @param $rateTo
     * @return string
     */
    private function makeConversion($amount, $rateFrom, $rateTo)
    {
        $amountInEuro = $this->convertToEuro($amount, $rateFrom);
        return number_format(round(($amountInEuro * $rateTo), $this->conversion->getDecimal() , $this->conversion->getRoundMode()), $this->conversion->getDecimal(), $this->conversion->getPoint(), $this->conversion->getThousandsSep());
    }

    /**
     * Converts provided amount to euro
     *
     * @param $amount
     * @param $rate
     * @return float
     */
    private function convertToEuro($amount, $rate)
    {
        return $amount / $rate;
    }


} 
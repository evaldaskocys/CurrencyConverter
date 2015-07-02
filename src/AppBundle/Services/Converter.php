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

    private function getCurrencyRateBySourceAndDate($currency, $date)
    {
        if ($currency == "EUR"){
            return 1;
        }
        return $this->em->getRepository('AppBundle:Currency')->findRateByDateAndShortNameAndCurrency($date, $this->conversion->getShortName(), $currency);
    }

    private function makeConversion($amount, $rateFrom, $rateTo)
    {
        $amountInEuro = $this->convertToEuro($amount, $rateFrom);
        return number_format(round(($amountInEuro * $rateTo), $this->conversion->getDecimal() , $this->conversion->getRoundMode()), $this->conversion->getDecimal(), $this->conversion->getPoint(), $this->conversion->getThousandsSep());
    }

    private function convertToEuro($amount, $rate)
    {
        return $amount / $rate;
    }


} 
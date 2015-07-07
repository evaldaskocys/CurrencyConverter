<?php

namespace AppBundle\Services;

use AppBundle\Utils\SourceConversionInterface;
use AppBundle\Utils\SourceCrawlerInterface;
use Doctrine\ORM\EntityManager;


class Converter {

    private $response = array(
        'valid' => true,
        'amount' => 0,
        'currency' => '',
        'message' => ''
    );

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
     * @param $currencyCodeFrom
     * @param $currencyCodeTo
     * @return string
     */
    public function convert($date, $amount, $currencyCodeFrom, $currencyCodeTo)
    {
        $currencyFrom = $this->getCurrencyRateBySourceAndDate($currencyCodeFrom, $date);
        $currencyTo= $this->getCurrencyRateBySourceAndDate($currencyCodeTo, $date);
        $this->validateAmount($amount);

        dump($this->response);
        if ($this->response['valid']){
            $this->response['amount'] = $this->makeConversion($amount, $currencyFrom->getRate(), $currencyTo->getRate());
            $this->response['currency'] = $currencyTo->getCurrency();
        }
        return $this->response;
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

        if (is_null($rate = $this->em->getRepository('AppBundle:Currency')->findRateByDateAndShortNameAndCurrency($date, $this->conversion->getShortName(), $currency))) {
            $this->response['valid'] = false;
            $this->response['message'] .= "Valiutos ".$currency." kursas ".$date." datai nerastas. ";
        }
        return $rate;
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
        $amountInBaseCurrency = $this->convertToBaseCurrency($amount, $rateFrom);
        return number_format(round(($amountInBaseCurrency * $rateTo), $this->conversion->getDecimal() , $this->conversion->getRoundMode()), $this->conversion->getDecimal(), $this->conversion->getPoint(), $this->conversion->getThousandsSep());
    }

    /**
     * Converts provided amount to base currency of the source
     *
     * @param $amount
     * @param $rate
     * @return float
     */
    private function convertToBaseCurrency($amount, $rate)
    {
        return $amount / $rate;
    }

    /**
     * Checks if amount is a valid number for currency
     *
     * @param $amount
     */
    private function validateAmount($amount)
    {
        if (!is_numeric($amount) || $amount < 0) {
            $this->response['valid'] = false;
        }
    }

} 
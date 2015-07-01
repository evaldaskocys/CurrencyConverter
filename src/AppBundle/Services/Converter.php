<?php

namespace AppBundle\Services;

use AppBundle\Utils\SourceConversionInterface;
use Doctrine\ORM\EntityManager;


class Converter {

    private $conversion;
    private $em;

    /**
     *
     * @param SourceConversionInterface $conversion
     * @param EntityManager $entityManager
     */
    public function __construct(SourceConversionInterface $conversion, EntityManager $entityManager)
    {
        $this->conversion = $conversion;
        $this->em = $entityManager;
    }

    /**
     * Convert
     *
     * @param $date
     * @param $amount
     * @param $currencyFrom
     * @param $currencyTo
     */
    public function convert($date='2015-07-01', $amount=50, $currencyFrom='USD', $currencyTo='CAD')
    {
        $currencyFromRate = $this->getCurrencyRateBySourceAndDate($currencyFrom, $date);
        $currencyToRate = $this->getCurrencyRateBySourceAndDate($currencyTo, $date);

        return $this->makeConversion($amount, $currencyFromRate, $currencyToRate);
    }

    private function getCurrencyRateBySourceAndDate($currency, $date)
    {
        return $this->em->getRepository('AppBundle:Currency')->findOneBy(array(
                'currency' => $currency,
                'createdAt' => $date,
                'sourceShortName' => $this->conversion->getSourceCode()
            )
        );
    }

    private function makeConversion($amount, $rateFrom, $rateTo)
    {
        
    }


} 
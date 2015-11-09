<?php

namespace AppBundle\Tests\Services;

use AppBundle\Services\Converter;
use AppBundle\Utils\ECBConversionStrategy;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider inputDataProvider
     *
     * @param $sourceCode
     * @param $date
     * @param $amount
     * @param $currencyCodeFrom
     * @param $currencyCodeTo
     * @param $rateFrom
     * @param $rateTo
     * @param array $result
     */
    public function testConvert($sourceCode, $date, $amount, $currencyCodeFrom, $currencyCodeTo, $rateFrom, $rateTo, array $result)
    {
        $strategy = new ECBConversionStrategy();

        if ($date == '2014-01-01') {
            $currencyFrom = null;
            $currencyTo = null;
        } else {
            $currencyFrom = $this->getMock('\AppBundle\Entity\Currency');
            $currencyFrom->expects($this->any())
                ->method('getRate')
                ->will($this->returnValue($rateFrom));
            $currencyFrom->expects($this->any())
                ->method('getCurrency')
                ->will($this->returnValue($currencyCodeFrom));

            $currencyTo = $this->getMock('\AppBundle\Entity\Currency');
            $currencyTo->expects($this->any())
                ->method('getRate')
                ->will($this->returnValue($rateTo));
            $currencyTo->expects($this->any())
                ->method('getCurrency')
                ->will($this->returnValue($currencyCodeTo));
        }

        $currencyRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->setMethods(array('findRateByDateAndShortNameAndCurrency'))
            ->disableOriginalConstructor()
            ->getMock();
        $currencyRepository->expects($this->at(0))
            ->method('findRateByDateAndShortNameAndCurrency')
            ->with($date, $sourceCode, $currencyCodeFrom)
            ->will($this->returnValue($currencyFrom));

        $currencyRepository->expects($this->at(1))
            ->method('findRateByDateAndShortNameAndCurrency')
            ->with($date, $sourceCode, $currencyCodeTo)
            ->will($this->returnValue($currencyTo));

        // Create a map of arguments to return values.
        /*$map = array(
            array($date, $sourceCode, $currencyCodeFrom, $currencyUSD),
            array($date, $sourceCode, $currencyCodeTo, $currencyEUR),
        );
        $currencyRepository->method('findRateByDateAndShortNameAndCurrency')
            ->will($this->returnValueMap($map));*/

        $mockManager = $this
            ->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $mockManager->expects($this->any())
            ->method('getRepository')
            ->with('AppBundle:Currency')
            ->will($this->returnValue($currencyRepository));

        $converter = new Converter($strategy, $mockManager);
        $this->assertEquals($result, $converter->convert($date, $amount, $currencyCodeFrom, $currencyCodeTo));
    }

    public function inputDataProvider()
    {
        return array(
            array(
                'ECB',
                '2015-07-07',
                '13.35',
                'EUR',
                'USD',
                1,
                1.0931,
                array(
                    'valid' => true,
                    'amount' => 14.59,
                    'currency' => 'USD',
                    'message' => '',
                ),
            ),
            array(
                'ECB',
                '2015-07-07',
                '13.35',
                'EUR',
                'GBP',
                1,
                0.7077,
                array(
                    'valid' => true,
                    'amount' => 9.45,
                    'currency' => 'GBP',
                    'message' => '',
                ),
            ),
            array(
                'ECB',
                '2015-07-07',
                '13.35',
                'DKK',
                'GBP',
                7.4614,
                0.7077,
                array(
                    'valid' => true,
                    'amount' => 1.27,
                    'currency' => 'GBP',
                    'message' => '',
                ),
            ),
            array(
                'ECB',
                '2015-07-07',
                'asddf',
                'DKK',
                'GBP',
                7.4614,
                0.7077,
                array(
                    'valid' => false,
                    'amount' => 0,
                    'currency' => '',
                    'message' => '',
                ),
            ),
            array(
                'ECB',
                '2015-07-07',
                '-20',
                'DKK',
                'GBP',
                7.4614,
                0.7077,
                array(
                    'valid' => false,
                    'amount' => 0,
                    'currency' => '',
                    'message' => '',
                ),
            ),
            array(
                'ECB',
                '2014-01-01',
                '10',
                'DKK',
                'GBP',
                7.4614,
                0.7077,
                array(
                    'valid' => false,
                    'amount' => 0,
                    'currency' => '',
                    'message' => 'Valiutos DKK kursas 2014-01-01 datai nerastas. Valiutos GBP kursas 2014-01-01 datai nerastas. ',
                ),
            ),
        );
    }
}

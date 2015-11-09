<?php

namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Currency;

class ProductRepositoryFunctionalTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    /**
     * @dataProvider inputDataProvider
     *
     * @param $date
     * @param $shortName
     * @param $currency
     */
    public function testFindRateByDateAndShortNameAndCurrency($date, $shortName, $currency)
    {
        /** @var Currency $currency */
        $currency = $this->em
            ->getRepository('AppBundle:Currency')
            ->findRateByDateAndShortNameAndCurrency($date->format('Y-m-d'), $shortName, $currency)
        ;

        $this->assertTrue((is_null($currency) || $currency instanceof Currency));
    }

    public function testFindAllCurrenciesForChoiceField()
    {
        $currencies = $this->em
            ->getRepository('AppBundle:Currency')
            ->findAllCurrenciesForChoiceField()
        ;

        $this->assertInternalType('array', $currencies);
    }

    public function inputDataProvider()
    {
        $date = new \DateTime();
        return array(
            array(
                $date,
                'ECB',
                'EUR',
            ),
            array(
                $date,
                'ECB',
                'USD',
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}
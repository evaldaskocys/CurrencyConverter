<?php

namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryFunctionalTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $shortName = 'ECB';
    private $currency = 'EUR';

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

    public function testFindRateByDateAndShortNameAndCurrency()
    {
        $date = new \DateTime();
        $products = $this->em
            ->getRepository('AppBundle:Currency')
            ->findRateByDateAndShortNameAndCurrency($date->format('Y-m-d'), $this->shortName, $this->currency)
        ;

        $this->assertTrue((is_null($products) || count($products) == 1));
    }

    public function testFindAllCurrenciesForChoiceField()
    {
        $currencies = $this->em
            ->getRepository('AppBundle:Currency')
            ->findAllCurrenciesForChoiceField()
        ;

        $this->assertInternalType('array', $currencies);
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
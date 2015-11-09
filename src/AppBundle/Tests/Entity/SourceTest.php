<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Currency;
use AppBundle\Entity\Source;

class SourceTest extends \PHPUnit_Framework_TestCase
{
    protected $source;

    protected function setUp()
    {
        $this->source = new Source();
        $this->source->setShortCode('ECB')
            ->setUrl('http://www.tst.com')
            ->setCreatedAt($date = new \DateTime(''));
        $currencyEur = new Currency();
        $currencyEur->setCurrency('EUR')
            ->setRate(1);

        $this->source->addCurrency($currencyEur);
    }

    public function testCanAddRemoveCurrencies()
    {
        $this->assertEquals(1, count($this->source->getCurrencies()));

        $currencyUsd = new Currency();
        $currencyUsd->setCurrency('USD')
            ->setRate(0.9);
        $this->source->addCurrency($currencyUsd);
        $this->assertEquals(2, count($this->source->getCurrencies()));

        $this->source->removeCurrency($currencyUsd);
        $this->assertEquals(1, count($this->source->getCurrencies()));
    }

    public function testReturnValues()
    {
        $this->assertEquals('ECB', $this->source->getShortCode());
        $this->assertEquals('http://www.tst.com', $this->source->getUrl());
        $this->assertInstanceOf('DateTime', $this->source->getCreatedAt());
    }
}

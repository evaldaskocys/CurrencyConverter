<?php

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Source;
use AppBundle\Entity\Currency;
/**
 * Class for generating demo users
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Function for persisting a demo user to database
     */
    public function load(ObjectManager $manager)
    {
        $source = new Source();
        $source->setShortCode("ECB")
            ->setUrl("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
        $manager->persist($source);

        $this->loadCurrencies($source, $manager);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

    protected function loadCurrencies(Source $source, ObjectManager $manager)
    {
        $currencies = array(
            array(
                'rate' => 1,
                'currency' => "EUR",
            ),
            array(
                'rate' => 1.1054,
                'currency' => "USD",
            ),
            array(
                'rate' => 0.7176,
                'currency' => "GBP",
            ),
        );

        foreach ($currencies as $row) {
            $currency = new Currency();
            $currency->setSource($source)
                ->setRate($row['rate'])
                ->setCurrency($row['currency']);
            $manager->persist($currency);
        }
    }
}
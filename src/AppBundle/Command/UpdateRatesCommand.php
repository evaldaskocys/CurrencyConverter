<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Source;
use AppBundle\Entity\Currency;

class UpdateRatesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('currency:rates:update')
            ->setDescription('Update currency rates.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $crawler = $this->getContainer()->get('crawler_ecb');
        $em = $this->getEntityManager();

        $source = $this->createSource($crawler->getShortName(), $crawler->getRemoteUrl());
        $em->persist($source);

        // create entry for base currency
        $baseCurrency = $this->createCurrency(1, $crawler->getBaseCurrency(), $source);
        $em->persist($baseCurrency);

        foreach ($crawler->getRates() as $rate) {
            $currency = $this->createCurrency($rate['rate'], $rate['currency'], $source);
            $em->persist($currency);
        }
        $em->flush();
        $output->writeln('Updated currency rates for ' . $crawler->getLongName() . '.');
    }

    protected function createSource($sourceShortName, $remoteUrl)
    {
        $source = new Source();
        $source->setShortCode($sourceShortName)
            ->setUrl($remoteUrl);
        return $source;
    }

    protected function createCurrency($rate, $currencyCode, Source $source)
    {
        $currency = new Currency();
        $currency->setSource($source)
            ->setRate($rate)
            ->setCurrency($currencyCode);
        return $currency;
    }

    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }
}
<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

        foreach ($crawler->getRates() as $rate) {
            $currency = $this->createCurrency($rate, $crawler->getShortName());
            $this->persistCurrency($currency);
        }
        $output->writeln('Updated currency rates for ' . $crawler->getShortName() . '.');
    }

    private function createCurrency($rate, $sourceShortName)
    {
        $currency = new Currency();
        $currency->setSourceShortName($sourceShortName)
            ->setRate($rate['rate'])
            ->setCurrency($rate['currency']);
        return $currency;
    }

    private function persistCurrency($currency)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($currency);
        $em->flush();
    }
}
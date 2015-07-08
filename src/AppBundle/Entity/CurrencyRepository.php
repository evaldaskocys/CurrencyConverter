<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ServiceRepository
 *
 */
class CurrencyRepository extends EntityRepository
{
    /**
     * @param $date
     * @param $shortName
     * @param $currency
     * @return mixed
     */
    public function findRateByDateAndShortNameAndCurrency($date, $shortName, $currency)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Currency', 'c')
            ->innerJoin('c.source','s')
            ->where('s.createdAt = :date')
            ->andWhere('s.shortCode = :short_code')
            ->andWhere('c.currency = :currency')
            ->setParameter('date', $date)
            ->setParameter('short_code', $shortName)
            ->setParameter('currency', $currency)
            ->setMaxResults(1)
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function findAllCurrenciesForChoiceField()
    {
        $query = $this->createQueryBuilder('c')
            ->select('c.currency')
            ->orderBy('c.currency', 'ASC')
            ->groupBy('c.currency')
            ->getQuery();

        $currencyChoices = array();
        foreach($query->getResult() as $uniqueCurrency){
            $currencyChoices[$uniqueCurrency['currency']] = $uniqueCurrency['currency'];
        }
        return $currencyChoices;
    }
}

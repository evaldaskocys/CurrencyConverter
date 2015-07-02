<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ConverterType extends AbstractType
{
    private $em;
    private $choicesForDate;
    private $choicesForCurrency;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->choicesForDate = $this->getChoicesForDate();
        $this->choicesForCurrency = $this->getChoicesForCurrency();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'choice', array(
                    'choices' => $this->choicesForDate,
                    'label' => 'Data'
                ))
            ->add('sellCurrency', 'choice', array(
                    'choices' => $this->choicesForCurrency,
                    'label' => 'Parduodama valiuta',
                ))
            ->add('amount','number', array(
                    'label' => 'Parduodama suma'
                ))
            ->add('buyCurrency', 'choice', array(
                    'choices' => $this->choicesForCurrency,
                    'label' => 'Perkama valiuta',
                ));
    }

    public function getName()
    {
        return 'converter';
    }

    private function getChoicesForDate()
    {
        return $this->em->getRepository('AppBundle:Currency')->findAllDatesForChoiceField();
    }

    private function getChoicesForCurrency()
    {
        return $this->em->getRepository('AppBundle:Currency')->findAllCurrenciesForChoiceField();
    }
}
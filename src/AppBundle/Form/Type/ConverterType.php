<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConverterType extends AbstractType
{
    private $dateChoices;

    public function __construct($dateChoices)
    {
        $this->dateChoices = $dateChoices;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           /* ->add('date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'label' => 'Data',
                ))*/
            ->add('date', 'choice', array(
                    'choices' => $this->dateChoices,
                    'label' => 'Data'
                ))
            ->add('sellCurrency', 'entity', array(
                    'class' => 'AppBundle:Currency',
                    'label' => 'Parduodama valiuta',
                ))
            ->add('postCode','number', array(
                    'label' => 'Parduodama suma'
                ))
            ->add('buyCurrency', 'entity', array(
                    'class' => 'AppBundle:Currency',
                    'label' => 'Perkama valiuta',
                ));
    }

    public function getName()
    {
        return 'converter';
    }
}
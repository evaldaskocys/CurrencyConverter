<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConverterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'label' => 'Data',
                ))
            ->add('sellCurrency', 'entity', array(
                    'class' => 'AppBundle:Currency',
                    'label' => 'Parduodama valiuta',
                ))
            ->add('postCode','money', array(
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
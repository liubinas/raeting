<?php

namespace Raeting\RaetingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SignalsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('buy', 'choice', array(
                'choices' => array('Buy (Long)', 'Sell (Short)'),
                'expanded' => true,
                'multiple' => false,
                'label' => '&nbsp;'
            ))
            ->add('symbol', 'extentity', array(
                'class' => 'RaetingRaetingBundle:Symbol',
                'property' => 'id',
                'label' => 'Symbol',
            ))
            ->add('open', 'text', array(
                'label' => 'Open price',
            ))
            ->add('take_profit', 'text', array(
                'label' => 'Take profit',
            ))
            ->add('stop_loss', 'text', array(
                'label' => 'Stop loss',
            ))
            ->add('description', 'textarea')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Raeting\RaetingBundle\Entity\Signals'
        ));
    }

    public function getName()
    {
        return 'raeting_raetingbundle_signalstype';
    }
}

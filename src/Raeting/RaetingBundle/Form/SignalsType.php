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
            ->add('quote', 'text', array(
                'label' => 'Quote',
                'attr' => array('class' => 'input-small', 'placeholder' => 'ex. EUR/USD')
            ))
            ->add('open', 'text', array(
                'label' => 'Open price',
                'attr' => array('class' => 'input-small', 'placeholder' => '0.0000')
            ))
            ->add('take_profit', 'text', array(
                'label' => 'Take profit',
                'attr' => array('class' => 'input-small', 'placeholder' => '0.0000')
            ))
            ->add('stop_loss', 'text', array(
                'label' => 'Stop loss',
                'attr' => array('class' => 'input-small', 'placeholder' => '0.0000')
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

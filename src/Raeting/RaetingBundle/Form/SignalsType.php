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
            ->add('status')
            ->add('quote')
            ->add('type')
            ->add('open')
            ->add('profit')
            ->add('loss')
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

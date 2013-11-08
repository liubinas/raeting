<?php

namespace Raeting\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array(
            ))
            ->add('lastname', 'text', array(
            ))
            ->add('company', 'text', array(
            ))
            ->add('twitter', 'text', array(
                'required' => false
            ))
            ->add('about', 'textarea', array(
                'required' => false
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Raeting\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'raeting_userbundle_profiletype';
    }
}

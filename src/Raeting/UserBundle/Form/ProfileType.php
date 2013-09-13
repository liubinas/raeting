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
                'label' => 'Name',
                'attr' => array('class' => 'input-small', 'placeholder' => 'Name')
            ))
            ->add('lastname', 'text', array(
                'label' => 'Surname',
                'attr' => array('class' => 'input-small', 'placeholder' => 'Surname')
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

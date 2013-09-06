<?php

namespace Raeting\UserBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\CallbackValidator,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormBuilder,
    Symfony\Component\Form\FormError,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * User registration form type.
 */
class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'text');
        $builder->add('lastname', 'text');
        $builder->add('email', 'email');
        $builder->add('password', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => 'password'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Raeting\UserBundle\Entity\User'
        ));
    }

    /**
     * Canonical form type name.
     * 
     * @return string
     */
    public function getName()
    {
        return 'registration';
    }
}

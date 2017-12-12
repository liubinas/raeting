<?php

namespace EstinaCMF\UserBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\CallbackValidator,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormError,
    Symfony\Component\Form\FormInterface;

/**
 * Change password form type.
 */
class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('hash', 'text');
        $builder->add('password', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => 'password'
        ));
    }

    /**
     * Canonical form type name.
     * 
     * @return string
     */
    public function getName()
    {
        return 'change_password';
    }
}

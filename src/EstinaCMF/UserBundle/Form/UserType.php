<?php

namespace EstinaCMF\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * User form type.
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('password', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => 'password'
        ));
    }

    public function getName()
    {
        return 'user';
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'EstinaCMF\UserBundle\Security\User');
    }
}


<?php

namespace Raeting\UserBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormInterface;

/**
 * Password recovery form type.
 */
class RecoverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
    }

    /**
     * Canonical form type name.
     * 
     * @return string
     */
    public function getName()
    {
        return 'recover';
    }
}


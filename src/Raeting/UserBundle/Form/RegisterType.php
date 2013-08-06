<?php

namespace Raeting\UserBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\CallbackValidator,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormBuilder,
    Symfony\Component\Form\FormError;

/**
 * User registration form type.
 */
class RegisterType extends AbstractType
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

        $this->setValidators($builder);
    }

    protected function setValidators($builder)
    {
        // $builder->addValidator(new CallbackValidator(
        //     function (FormInterface $form) {
        //         if (empty($form['terms'])) {
        //             //@todo translate
        //             $form->addError(new FormError('Please accept the terms and conditions'));
        //         }

        //     }
        // ));
    }

    /**
     * Canonical form type name.
     * 
     * @return string
     */
    public function getName()
    {
        return 'register';
    }
}

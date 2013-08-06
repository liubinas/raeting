<?php

namespace Raeting\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Raeting\UserBundle\Service\User;

/**
 * User form type.
 */
class NewPasswordType extends AbstractType
{
    /**
     * @var Raeting\UserBundle\Service\User
     */
    protected $userService;

    /**
     * __construct
     * @param Raeting\UserBundle\Service\User $userService
     */
    public function __construct(User $userService)
    {
        $this->userService = $userService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('password_old', 'password', array('required' => true));
        $builder->add('password_new', 'password', array('required' => true));
        $builder->add('password_confirm', 'password', array('required' => true));

        $this->setValidators($builder, $this->userService);
    }

    /**
     * Form name
     *
     * @return string
     */
    public function getName()
    {
        return 'new_password';
    }

    /**
     * @param array $options
     *
     * @return Collection
     */
    public function getDefaultOptions(array $options)
    {
        $collectionConstraint = new Collection(array(
            'id' => array(new NotBlank()),
            'password_old' => array(new MinLength(6), new MaxLength(20)),
            'password_new' => array(new MinLength(6), new MaxLength(20)),
            'password_confirm' => array(new MinLength(6), new MaxLength(20))
        ));

        return array('validation_constraint' => $collectionConstraint);
    }

    /**
     * setValidators
     * @param FormBuilder                    $builder
     * @param Raeting\UserBundle\Service\User $userService
     */
    protected function setValidators(FormBuilder $builder, User $userService)
    {
        $builder->addValidator(new CallbackValidator(function(FormInterface $form) use ($userService) {
            $passwordOld = $form['password_old']->getData();
            if (null !== $passwordOld) {
                $passwordNew = $form['password_new']->getData();
                $passwordConfirm = $form['password_confirm']->getData();
                if (null === $passwordNew) {
                    $form['password_new']->addError(new FormError('This value is invalid.'));
                } elseif (null === $passwordConfirm) {
                    $form['password_confirm']->addError(new FormError('This value is invalid.'));
                } elseif ($passwordNew !== $passwordConfirm) {
                    $form['password_new']->addError(new FormError('Passwords do not match.'));
                } else {
                    $user = $userService->getById($form['id']->getData());
                    if ($userService->encodePassword($passwordOld) !== $user['password']) {
                        $form['password_old']->addError(new FormError('Your password is incorrect.'));
                    }
                }
            }

        }));
    }
}

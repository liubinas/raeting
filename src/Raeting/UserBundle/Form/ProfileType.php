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
class ProfileType extends AbstractType
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
        $builder->add('firstname', 'text', array('max_length' => 50));
        $builder->add('lastname', 'text', array('max_length' => 50));

        $builder->add('postal_code', 'text', array('max_length' => 45, 'required' => false));
        $builder->add('state', 'text', array('max_length' => 45, 'required' => false));
        
        $builder->add('street', 'text', array('max_length' => 45));
    }

    /**
     * Form name
     *
     * @return string
     */
    public function getName()
    {
        return 'profile';
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
            'firstname' => array(new NotBlank(), new MaxLength(50)),
            'lastname' => array(new NotBlank(), new MaxLength(50)),
            'street' => array(new NotBlank(), new MaxLength(45)),
            'state' => array(new NotBlank(), new MaxLength(45)),
            'postal_code' => array(new MaxLength(45))
        ));

        return array('validation_constraint' => $collectionConstraint);
    }
}

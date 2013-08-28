<?php
namespace Raeting\RaetingBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Bridge\Doctrine\Form\EventListener\MergeDoctrineCollectionListener;
use Doctrine\Common\Persistence\ObjectManager;

class ExtEntityType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['multiple']) {
            // 
        } else {
            //
        }
    }

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'extentity';
    }
}

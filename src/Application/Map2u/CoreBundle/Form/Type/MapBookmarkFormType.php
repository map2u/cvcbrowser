<?php

namespace Application\Map2u\CoreBundle\Form\Type;

use FOS\UserBundle\Form\DataTransformer\UserToUsernameTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form type for representing a UserInterface instance by its username string.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class MapBookmarkFormType extends AbstractType {

    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class) {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', "text", array('label' => 'Name', 'required' => true, 'mapped' => false))
                ->add('lat', "hidden")
                ->add('lng', "hidden")
                ->add('seq', "hidden")
                ->add('zoomLevel', "choice", array('label' => 'Map Scale', 'required' => true, 'mapped' => false, "choices" => array(10 => "1:500,000",11 => "1:250,000", 12 => "1:150,000", 13 => "1:70,000", 14 => "1:35,000", 15 => "1:15,000", 16 => "1:8,000", 17 => "1:4,000")))
                ->add('address', "text", array('label' => 'Map Center Address', 'required' => true, 'mapped' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'mapbookmark',
        ));
    }

    public function getName() {
        return 'map2u_mapbookmark';
    }

}

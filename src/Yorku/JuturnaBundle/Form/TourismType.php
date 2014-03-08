<?php

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class TourismType extends AbstractType {

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('name')
 //        ->add('tourismgeoms','text',array('read_only'=>true))
        ->add('tourismgeoms', 'entity', array(
          'class' => 'YorkuJuturnaBundle:TourismGeoms',
          'property' => 'name',
          'query_builder' => function(EntityRepository $er ) use ( $options ) {
                  return $er->createQueryBuilder('w')
                  ->orderBy('w.name', 'ASC')
                  ->where('w.id = ?1')
             //     ->andWhere('w.visible = 1')
             //     ->andWhere('w.booked = 0')
                  ->setParameter(1, $options['tourismgeomsid']);
                }
        ))
        ->add('images_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Image Files', 'attr' => array("multiple" => true)))
        ->add('videos_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Video Files', 'attr' => array("multiple" => true)))
        ->add('audios_file', 'file', array('required' => false, 'mapped' => false, 'label' => 'Audio Files', 'attr' => array("multiple" => true)))
        ->add('isPublished')
        ->add('description')
        //->add('user')
    ;
  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'Yorku\JuturnaBundle\Entity\Tourism',
      'tourismgeomsid' => null
    ));
  }

  /**
   * @return string
   */
  public function getName() {
    return 'yorku_juturnabundle_tourism';
  }

}

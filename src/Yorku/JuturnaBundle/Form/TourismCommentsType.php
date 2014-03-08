<?php

namespace Yorku\JuturnaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class TourismCommentsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
            ->add('user','entity',array('multiple'=>false,
              'required'=>false,'read_only'=>true,
              'class' => 'Application\Sonata\UserBundle\Entity\User',
               'query_builder' => function(EntityRepository $er ) use ( $options ) {
                  return $er->createQueryBuilder('w')
           
                  ->where('w.id = ?1')
             //     ->andWhere('w.visible = 1')
             //     ->andWhere('w.booked = 0')
                  ->setParameter(1, $options['userid']|1);
                }
              ))
            ->add('tourism','entity',array('multiple'=>false,'read_only'=>true,
              'class' =>'Yorku\JuturnaBundle\Entity\Tourism',
                'query_builder' => function(EntityRepository $er ) use ( $options ) {
                  return $er->createQueryBuilder('w')
                  ->orderBy('w.name', 'ASC')
                  ->where('w.id = ?1')
             //     ->andWhere('w.visible = 1')
             //     ->andWhere('w.booked = 0')
                  ->setParameter(1, $options['tourismid']);
                }
            ))
            ->add('title')
            ->add('code')
            ->add('isPublished')
            ->add('content','sonata_formatter_type', array(
              'event_dispatcher' => $builder->getEventDispatcher(),
              'format_field'   => 'contentFormatter',
              'source_field'   => 'rawContent',
              'source_field_options'      => array(
               'attr' => array('class' => 'span10', 'rows' => 10)
              ),
              'target_field'   => 'content',
              'listener'       => true,
          ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yorku\JuturnaBundle\Entity\TourismComments',
            'userid'         => null,
             'tourismid'  => null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yorku_juturnabundle_tourismcomments';
    }
}

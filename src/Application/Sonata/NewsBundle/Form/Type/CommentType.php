<?php

<<<<<<< HEAD
/**
 * <copyright>
 * This file/program is free and open source software released under the GNU General Public
 * License version 3, and is distributed WITHOUT ANY WARRANTY. A copy of the GNU General
 * Public Licence is available at http://www.gnu.org/licenses
 * </copyright>
 *
 * <author>Shuilin (Joseph) Zhao</author>
 * <company>SpEAR Lab, Faculty of Environmental Studies, York University
 * <email>zhaoshuilin2004@yahoo.ca</email>
 * <date>created at 2014/01/06</date>
 * <date>last updated at 2015/03/11</date>
 * <summary>This is the extend of Symfony\Component\Form\AbstractType</summary>
 * <purpose>for entity Comment form type</purpose>
=======
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
>>>>>>> update map2u bundles
 */

namespace Sonata\NewsBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True;

class CommentType extends AbstractType {

  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('name', null, array('label' => 'form.comment.name'))
        ->add('email', 'email', array('required' => false, 'label' => 'form.comment.email'))
        ->add('url', 'url', array('required' => false, 'label' => 'form.comment.url'))
        ->add('message', null, array('label' => 'form.comment.message'))
        ->add('recaptcha', 'ewz_recaptcha', array(
          'attr' => array(
            'options' => array(
              'theme' => 'red'
            )
          ),
          'mapped' => false,
          'constraints' => array(
            new True()
          )
        ))
    ;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'sonata_post_comment';
  }

  /**
   * {@inheritdoc}
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
;
    $resolver->setDefaults(array(
      'translation_domain' => 'SonataNewsBundle'
    ));
  }

}

<?php

namespace Yorku\JuturnaBundle\Controller;

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
 * <date>created at 2014/01/07</date>
 * <date>last updated at 2015/05/21</date>
 * <summary>This file is supposed for administrator to create,update system parameters</summary>
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yorku\JuturnaBundle\Entity\Systemparams;
use Yorku\JuturnaBundle\Form\SystemparamsType;

/**
 * Systemparams controller.
 *
 * @Route("/systemparams")
 */
class SystemparamsController extends Controller {

    /**
     * Lists all Systemparams entities.
     *
     * @Route("/", name="systemparams")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('YorkuJuturnaBundle:Systemparams')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Systemparams entity.
     *
     * @Route("/", name="systemparams_create")
     * @Method("POST")
     * @Template("YorkuJuturnaBundle:Systemparams:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Systemparams();
        $form = $this->createForm(new SystemparamsType(), $entity);
        $form->add('file1', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->add('file2', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->add('file3', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
        ));


        if ($request->getMethod() == "POST") {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                //   $data = $form->getData();
                if ($this->getUser())
                    $user = $this->getUser();
                else
                    $user = $em->getRepository('YorkuJuturnaBundle:Users')->findOneById(1);
                $dir = $this->get('kernel')->getRootDir() . '/../web/img';

                if ($form['file1']->getData() != null) {
                    $form['file1']->getData()->move($dir, $form['file1']->getData()->getClientOriginalName());
                    $Logo1Blob = file_get_contents($dir . "/" . $form['file1']->getData()->getClientOriginalName());
                    $entity->setLogo1Imagetype($form['file1']->getData()->getClientMimeType());
                    $entity->setLogo1Filename($form['file1']->getData()->getClientOriginalName());
                    $entity->setLogo1Blob($Logo1Blob);
                }
                if ($form['file2']->getData() != null) {
                    $form['file2']->getData()->move($dir, $form['file2']->getData()->getClientOriginalName());
                    $Logo2Blob = file_get_contents($dir . "/" . $form['file2']->getData()->getClientOriginalName());
                    $entity->setLogo2Imagetype($form['file2']->getData()->getClientMimeType());
                    $entity->setLogo2Filename($form['file2']->getData()->getClientOriginalName());
                    $entity->setLogo2Blob($Logo2Blob);
                }
                if ($form['file3']->getData() != null) {
                    $form['file3']->getData()->move($dir, $form['file3']->getData()->getClientOriginalName());
                    $Logo3Blob = file_get_contents($dir . "/" . $form['file3']->getData()->getClientOriginalName());
                    $entity->setLogo3Imagetype($form['file3']->getData()->getClientMimeType());
                    $entity->setLogo3Filename($form['file3']->getData()->getClientOriginalName());
                    $entity->setLogo3Blob($Logo3Blob);
                }
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('systemparams_show', array('id' => $entity->getId())));
            }
        }
        $form->remove('logo1Blob')
                ->remove('logo2Blob')
                ->remove('logo3Blob')
                ->remove('logo1Imagetype')
                ->remove('logo2Imagetype')
                ->remove('logo3Imagetype');

        $form->submit($request);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Systemparams entity.
     *
     * @Route("/new", name="systemparams_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Systemparams();

        $form = $this->createForm(new SystemparamsType(), $entity);
        $form->add('file1', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->add('file2', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->add('file3', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->remove('logo1Blob')
                ->remove('logo2Blob')
                ->remove('logo3Blob')
                ->remove('logo1Imagetype')
                ->remove('logo2Imagetype')
                ->remove('logo3Imagetype')
        ;

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Systemparams entity.
     *
     * @Route("/{id}", name="systemparams_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Systemparams')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Systemparams entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Systemparams entity.
     *
     * @Route("/{id}/edit", name="systemparams_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Systemparams')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Systemparams entity.');
        }

        $editForm = $this->createForm(new SystemparamsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        $editForm->add('file1', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->add('file2', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->add('file3', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->remove('logo1Blob')
                ->remove('logo2Blob')
                ->remove('logo3Blob')
                ->remove('logo1Imagetype')
                ->remove('logo2Imagetype')
                ->remove('logo3Imagetype')
        ;
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Systemparams entity.
     *
     * @Route("/{id}", name="systemparams_update")
     * @Method("PUT")
     * @Template("YorkuJuturnaBundle:Systemparams:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Systemparams')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Systemparams entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SystemparamsType(), $entity);
        $editForm->add('file1', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->add('file2', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
                ))
                ->add('file3', 'file', array('label' => 'Image File Name :', "mapped" => false, "required" => false
        ));
        if ($request->getMethod() == "PUT") {
            $editForm->bind($request);

            if ($editForm->isValid()) {


                $em = $this->getDoctrine()->getManager();
                //   $data = $form->getData();
                if ($this->getUser())
                    $user = $this->getUser();
                else
                    $user = $em->getRepository('YorkuJuturnaBundle:Users')->findOneById(1);
                $dir = $this->get('kernel')->getRootDir() . '/../web/img';

                if ($editForm['file1']->getData() != null) {
                    $editForm['file1']->getData()->move($dir, $editForm['file1']->getData()->getClientOriginalName());
                    $Logo1Blob = file_get_contents($dir . "/" . $editForm['file1']->getData()->getClientOriginalName());
                    $entity->setLogo1Imagetype($editForm['file1']->getData()->getClientMimeType());
                    $entity->setLogo1Filename($editForm['file1']->getData()->getClientOriginalName());
                    $entity->setLogo1Blob($Logo1Blob);
                }
                if ($editForm['file2']->getData() != null) {
                    $editForm['file2']->getData()->move($dir, $editForm['file2']->getData()->getClientOriginalName());
                    $Logo2Blob = file_get_contents($dir . "/" . $editForm['file2']->getData()->getClientOriginalName());
                    $entity->setLogo2Imagetype($editForm['file2']->getData()->getClientMimeType());
                    $entity->setLogo2Filename($editForm['file2']->getData()->getClientOriginalName());
                    $entity->setLogo2Blob($Logo2Blob);
                }
                if ($editForm['file3']->getData() != null) {
                    $editForm['file3']->getData()->move($dir, $editForm['file3']->getData()->getClientOriginalName());
                    $Logo3Blob = file_get_contents($dir . "/" . $editForm['file3']->getData()->getClientOriginalName());
                    $entity->setLogo3Imagetype($editForm['file3']->getData()->getClientMimeType());
                    $entity->setLogo3Filename($editForm['file3']->getData()->getClientOriginalName());
                    $entity->setLogo3Blob($Logo3Blob);
                }

                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('systemparams_edit', array('id' => $id)));
            }
        }
        $editForm->remove('logo1Blob')
                ->remove('logo2Blob')
                ->remove('logo3Blob')
                ->remove('logo1Imagetype')
                ->remove('logo2Imagetype')
                ->remove('logo3Imagetype')
        ;

        $editForm->submit($request);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Systemparams entity.
     *
     * @Route("/{id}", name="systemparams_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YorkuJuturnaBundle:Systemparams')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Systemparams entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('systemparams'));
    }

    /**
     * Creates a form to delete a Systemparams entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}

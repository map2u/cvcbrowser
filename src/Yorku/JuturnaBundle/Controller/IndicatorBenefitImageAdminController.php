<?php

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
 * <summary>This file is created for IndicatorBenefitImage controller with bundle YorkuJuturnaBundle</summary>
 * <purpose>manage all IndicatorBenefitImage entity actions process in this controller, for custom process create a new IndicatorBenefitImage and update an existing IndicatorBenefitImage</purpose>
 */

namespace Yorku\JuturnaBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sonata\AdminBundle\Exception\ModelManagerException;

class IndicatorBenefitImageAdminController extends CRUDController {

    public function createAction(Request $request = NULL) {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }

                try {
                    $object = $this->admin->create($object);
                    $object = $this->saveUploadedFiles($form, $object);
                    $this->admin->update($object);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object)
                        ));
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_create_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                            'sonata_flash_error', $this->admin->trans(
                                    'flash_create_error', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
        ));
    }

    public function editAction($id = NULL, Request $request = NULL) {

        $templateKey = 'edit';

        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);


        if ($this->getRestMethod() == 'POST') {
            $form->bind($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $object = $this->saveUploadedFiles($form, $object);
                $this->admin->update($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                                'result' => 'ok',
                                'objectId' => $this->admin->getNormalizedIdentifier($object)
                    ));
                }
                //  $flash =$this->getFlash('no_shape_file_uploaded');
                //  if(empty($flash))
                //   $this->addFlash('sonata_flash_success', 'flash_edit_success');
                // redirect to edit mode
                return $this->redirectTo($object);
            }
            $return = $this->checkFormValid($isFormValid);
            if ($return !== null) {
                $templateKey = $return;
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'edit',
                    'form' => $view,
                    'object' => $object,
        ));
    }

    /*
     *
     */

    private function checkFormValid($isFormValid) {
        $templateKey = null;
        // show an error message if the form failed validation
        if (!$isFormValid) {
            if (!$this->isXmlHttpRequest()) {
                $this->addFlash('sonata_flash_error', 'flash_create_error');
            }
        } elseif ($this->isPreviewRequested()) {
            // pick the preview template if the form was valid and preview was requested
            $templateKey = 'preview';
            $this->admin->getShow();
        }
        return $templateKey;
    }

    /*
     * function purpose: save uploaded image file
     * parameters: $form, $object
     * return: $object
     */

    private function saveUploadedFiles($form, $object) {
        $imageFile = $form['image_file']->getData();


        $dir = './uploads/images/indicatorbenefitimages/' . $object->getId();
        if (file_exists($dir) == false) {
            shell_exec("mkdir -p " . $dir);
        }
        $images_array = array();
        if ($imageFile != null) {
            if (is_array($imageFile)) {
                foreach ($imageFile as $file) {

                    if ($file != null) {
                        array_push($images_array, str_replace(" ", "_", $file->getClientOriginalName()));
                        $file->move($dir, str_replace(" ", "_", $file->getClientOriginalName()));
                    }
                }
            } else {

                array_push($images_array, str_replace(" ", "_", $imageFile->getClientOriginalName()));
                $imageFile->move($dir, str_replace(" ", "_", $imageFile->getClientOriginalName()));
            }
            $object->setFileName(json_encode($images_array));
        }


        return $object;
    }

}

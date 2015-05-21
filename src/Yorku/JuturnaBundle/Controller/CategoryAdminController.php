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
 * <date>created at 2014/11/04</date>
 * <date>last updated at 2015/03/15</date>
 * <summary>This file is created for admin user created or modify category</summary>
 */
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;

// administrator created or modify Category class object
class CategoryAdminController extends CRUDController {

    // developer can moddify code to custom the function with category class object creation
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
            $form->bind($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

                // check and save uploaded image, function return $object
                $object = $this->saveUploadedImage($form, $object);

                $this->admin->create($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                                'result' => 'ok',
                                'objectId' => $this->admin->getNormalizedIdentifier($object)
                    ));
                }

                $this->addFlash('sonata_flash_success', 'flash_create_success');
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
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
        ));
    }

    // developer can moddify code to custom the function with category class object update
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

                // check and save uploaded image, function return $object
                $object = $this->saveUploadedImage($form, $object);
                $this->admin->update($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                                'result' => 'ok',
                                'objectId' => $this->admin->getNormalizedIdentifier($object)
                    ));
                }

                $this->addFlash('sonata_flash_success', 'flash_edit_success');

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

    private function saveUploadedImage($form, $object) {


        $imageFile = $form['flashimage_files']->getData();

        // set upload image to caateories folder and category id number subfolder
        $dir = './uploads/images/categories/' . $object->getId();
        if (file_exists($dir) == false) {
            shell_exec("mkdir -p " . $dir);
        }

        $images_array = array();
        if ($imageFile != null) {
            if (is_array($imageFile)) {
                foreach ($imageFile as $file) {
                    if ($file != null) {
                        // replace all file name space with under score _
                        array_push($images_array, str_replace(" ", "_", $file->getClientOriginalName()));
                        $file->move($dir, str_replace(" ", "_", $file->getClientOriginalName()));
                    }
                }
            } else {
                // replace all file name space with under score _
                array_push($images_array, str_replace(" ", "_", $imageFile->getClientOriginalName()));
                $imageFile->move($dir, str_replace(" ", "_", $imageFile->getClientOriginalName()));
            }
            if (count($images_array) > 0) {
                $object->setFlashImages(serialize($images_array));
            }
        }

        $meadiagramFile = $form['meadiagram_file']->getData();

        $dir = './uploads/images/meadiagrams';
        // save meadiagrams to meadiagrams folder
        if ($meadiagramFile != null) {
            // replace all file name space with under score _
            $meadiagramFile->move($dir, str_replace(" ", "_", $meadiagramFile->getClientOriginalName()));
            $object->setMeaDiagram(str_replace(" ", "_", $meadiagramFile->getClientOriginalName()));
        }
        return $object;
    }

}

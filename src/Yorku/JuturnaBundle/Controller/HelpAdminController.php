<?php

namespace Yorku\JuturnaBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HelpAdminController extends CRUDController {

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
            //   $this->addFlash('sonata_flash_success', $isFormValid);
            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                // check and save uploaded image, function return $object
           //     var_dump($object->getActive());

                if ($object->getActive()) {
                    $em = $this->getDoctrine()->getManager();
                    $helps = $em->getRepository("YorkuJuturnaBundle:Help")->findBy(array("helpType" => $object->getHelpType()));
                    foreach ($helps as $help) {
                        if ($help->getId() !== $object->getId()) {
                            $help->setActive(false);
                            $em->persist($help);
                        }
                    }
                    $em->flush();
                }
                $this->admin->create($object);
                $object = $this->saveUploadedFile($form, $object);

                $this->admin->update($object);

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
                $object = $this->saveUploadedFile($form, $object);
                if ($object->getActive()) {
                    $em = $this->getDoctrine()->getManager();
                    $helps = $em->getRepository("YorkuJuturnaBundle:Help")->findBy(array("helpType" => $object->getHelpType()));
                    foreach ($helps as $help) {
                        if ($help->getId() !== $object->getId()) {
                            $help->setActive(false);
                            $em->persist($help);
                        }
                    }
                    $em->flush();
                }
               
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

    private function saveUploadedFile($form, $object) {


        $helpFile = $form['help_file']->getData();



        $dir = './uploads/help/' . $object->getId();
        if (file_exists($dir) == false) {
            shell_exec("mkdir -p " . $dir);
        }

        if ($helpFile !== null) {
            $object->setFileName($helpFile->getClientOriginalName());
            $object->setFileType($helpFile->getMimeType());
            $helpFile->move($dir, $helpFile->getClientOriginalName());
        }

        $zipFile = $form['zip_file']->getData();

        if ($zipFile !== null) {
            $object->setZipFileName($zipFile->getClientOriginalName());
            $zipFile->move($dir, $zipFile->getClientOriginalName());
            exec("unzip " . $dir . "/" . $zipFile->getClientOriginalName() . " -d " . $dir);
        }
        return $object;
    }

}

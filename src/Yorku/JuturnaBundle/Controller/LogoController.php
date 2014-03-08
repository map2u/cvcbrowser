<?php

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yorku\JuturnaBundle\Entity\Logo;
use Yorku\JuturnaBundle\Form\LogoType;

/**
 * Logo controller.
 *
 * @Route("/logo")
 */
class LogoController extends Controller
{

    /**
     * Lists all Logo entities.
     *
     * @Route("/", name="logo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('YorkuJuturnaBundle:Logo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Logo entity.
     *
     * @Route("/", name="logo_create")
     * @Method("POST")
     * @Template("YorkuJuturnaBundle:Logo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Logo();
        $request = $this->getRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dir = './img';
           
            $file=$form['imagefile']->getData();
            if ($file != null)
            {
                $filename=str_replace(" ","_",$file->getClientOriginalName());
                $file->move($dir, $file->getClientOriginalName());
                rename($dir.'/'.$file->getClientOriginalName(),$dir.'/'.$filename);
                $entity->setImageFilename($filename);
            }
           
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('logo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Logo entity.
    *
    * @param Logo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Logo $entity)
    {
        $form = $this->createForm(new LogoType(), $entity, array(
            'action' => $this->generateUrl('logo_create'),
            'method' => 'POST',
        ));
        $form->add('imagefile','file',array('label' => 'Image File','mapped'=>false));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Logo entity.
     *
     * @Route("/new", name="logo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Logo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Logo entity.
     *
     * @Route("/{id}", name="logo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Logo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Logo entity.
     *
     * @Route("/{id}/edit", name="logo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Logo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logo entity.');
        }

        $editForm = $this->createEditForm($entity);
        
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Logo entity.
    *
    * @param Logo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Logo $entity)
    {
        $form = $this->createForm(new LogoType(), $entity, array(
            'action' => $this->generateUrl('logo_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        
                
        $form->add('imagefile','file',array('label' => 'Image File','mapped'=>false,'required'=>false,'attr' => array("accept" => "image/*")));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Logo entity.
     *
     * @Route("/update/{id}", name="logo_update")
     * @Method("POST")
     * @Template("YorkuJuturnaBundle:Logo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
 
        $entity = $em->getRepository('YorkuJuturnaBundle:Logo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $dir = './img';
            $file=$editForm['imagefile']->getData();
            if ($file != null)
            {
                $filename=str_replace(" ","_",$file->getClientOriginalName());
                $file->move($dir, $file->getClientOriginalName());
                rename($dir.'/'.$file->getClientOriginalName(),$dir.'/'.$filename);
                $entity->setImageFilename($filename);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('logo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Logo entity.
     *
     * @Route("/{id}", name="logo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YorkuJuturnaBundle:Logo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Logo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('logo'));
    }

    /**
     * Creates a form to delete a Logo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('logo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

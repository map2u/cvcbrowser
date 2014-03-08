<?php

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yorku\JuturnaBundle\Entity\Privileges;
use Yorku\JuturnaBundle\Form\PrivilegesType;

/**
 * Privileges controller.
 *
 * @Route("/privileges")
 */
class PrivilegesController extends Controller
{

    /**
     * Lists all Privileges entities.
     *
     * @Route("/", name="privileges")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('YorkuJuturnaBundle:Privileges')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Privileges entity.
     *
     * @Route("/", name="privileges_create")
     * @Method("POST")
     * @Template("YorkuJuturnaBundle:Privileges:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Privileges();
        $form = $this->createForm(new PrivilegesType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('privileges_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Privileges entity.
     *
     * @Route("/new", name="privileges_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Privileges();
        $form   = $this->createForm(new PrivilegesType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Privileges entity.
     *
     * @Route("/{id}", name="privileges_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Privileges')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Privileges entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Privileges entity.
     *
     * @Route("/{id}/edit", name="privileges_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Privileges')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Privileges entity.');
        }

        $editForm = $this->createForm(new PrivilegesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Privileges entity.
     *
     * @Route("/{id}", name="privileges_update")
     * @Method("PUT")
     * @Template("YorkuJuturnaBundle:Privileges:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Privileges')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Privileges entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PrivilegesType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('privileges_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Privileges entity.
     *
     * @Route("/{id}", name="privileges_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YorkuJuturnaBundle:Privileges')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Privileges entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('privileges'));
    }

    /**
     * Creates a form to delete a Privileges entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

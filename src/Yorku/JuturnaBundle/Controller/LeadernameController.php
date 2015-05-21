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
 * <date>created at 2014/01/06</date>
 * <date>last updated at 2015/05/19</date>
 * <summary>This file is created for create,update,delte and list  entities of Leadername</summary>
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yorku\JuturnaBundle\Entity\Leadername;
use Yorku\JuturnaBundle\Form\LeadernameType;

/**
 * Leadername controller.
 *
 * @Route("/leadername")
 */
class LeadernameController extends Controller
{

    /**
     * Lists all Leadername entities.
     *
     * @Route("/", name="leadername")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('YorkuJuturnaBundle:Leadername')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Leadername entity.
     *
     * @Route("/", name="leadername_create")
     * @Method("POST")
     * @Template("YorkuJuturnaBundle:Leadername:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Leadername();
        $form = $this->createForm(new LeadernameType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('leadername_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Leadername entity.
     *
     * @Route("/new", name="leadername_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Leadername();
        $form   = $this->createForm(new LeadernameType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Leadername entity.
     *
     * @Route("/{id}", name="leadername_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Leadername')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leadername entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Leadername entity.
     *
     * @Route("/{id}/edit", name="leadername_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Leadername')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leadername entity.');
        }

        $editForm = $this->createForm(new LeadernameType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Leadername entity.
     *
     * @Route("/{id}", name="leadername_update")
     * @Method("PUT")
     * @Template("YorkuJuturnaBundle:Leadername:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Leadername')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leadername entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LeadernameType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('leadername_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Leadername entity.
     *
     * @Route("/{id}", name="leadername_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YorkuJuturnaBundle:Leadername')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Leadername entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('leadername'));
    }

    /**
     * Creates a form to delete a Leadername entity by id.
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

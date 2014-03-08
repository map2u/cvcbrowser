<?php

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yorku\JuturnaBundle\Entity\Bird;
use Yorku\JuturnaBundle\Form\BirdType;

/**
 * Bird controller.
 *
 * @Route("/bird")
 */
class BirdController extends Controller
{

    /**
     * Lists all Bird entities.
     *
     * @Route("/", name="bird")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('YorkuJuturnaBundle:Bird')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Bird entity.
     *
     * @Route("/", name="bird_create")
     * @Method("POST")
     * @Template("YorkuJuturnaBundle:Bird:new.html.twig")
     */
    public function createAction(Request $request)
    {
        
 
        
        $request = $this->getRequest();
        $entity = new Bird();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $filenames='';
        
        if ($form->isValid()) {
            
            $data=$form->getData();
            $files=$form['imagefiles']->getData();
            echo "1<br>";
            $dir = './uploads/images/birds';
            if(!file_exists($dir))
            {
                shell_exec('mkdir -p '.$dir);
            }
             echo "2<br>";
            if ($files != null)
            {
         //       foreach( $files as $filedata)
         //       {   $file=$filedata->getData();
                    $filename=str_replace(" ","_",$files->getClientOriginalName());
                    $files->move($dir, $files->getClientOriginalName());
                    rename($dir.'/'.$files->getClientOriginalName(),$dir.'/'.$filename);
         //           $files->move($dir,$filename );
                    if($filenames==='')
                        $filenames=$filename;
                    else
                        $filenames=$filenames.";".$filename;
             //   }
            }
            
            $entity->setImagePath($dir);
            $entity->setImageFilename($filenames);
            
            $em = $this->getDoctrine()->getManager();
            $entity->setTheGeom(new Point($entity->getLng(),$entity->getLat()));
            $em->persist($entity);
            $em->flush();
            return new JsonResponse(array('success' => true));
            
           // return $this->redirect($this->generateUrl('bird_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Bird entity.
    *
    * @param Bird $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Bird $entity)
    {
        $form = $this->createForm(new BirdType(), $entity, array(
            'action' => $this->generateUrl('bird_create'),
            'method' => 'POST',
        ));
        $form->add('imagefiles', 'file', array('label' => 'Bird Pictures','mapped'=>false,"required" => FALSE,
            "attr" => array(
                "accept" => "image/*",
         //       "multiple" => "multiple",
            )));
   //     $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Bird entity.
     *
     * @Route("/new", name="bird_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Bird();
        $form   = $this->createCreateForm($entity);
 //       $formView = $form->createView();
 //       $formView->getChild('imagefiles')->set('full_name', 'form[imagefiles][]');
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Bird entity.
     *
     * @Route("/{id}", name="bird_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Bird')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bird entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Bird entity.
     *
     * @Route("/{id}/edit", name="bird_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Bird')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bird entity.');
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
    * Creates a form to edit a Bird entity.
    *
    * @param Bird $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Bird $entity)
    {
        $form = $this->createForm(new BirdType(), $entity, array(
            'action' => $this->generateUrl('bird_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Bird entity.
     *
     * @Route("/{id}", name="bird_update")
     * @Method("PUT")
     * @Template("YorkuJuturnaBundle:Bird:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Bird')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bird entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bird_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Bird entity.
     *
     * @Route("/{id}", name="bird_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YorkuJuturnaBundle:Bird')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bird entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bird'));
    }

    /**
     * Creates a form to delete a Bird entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bird_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

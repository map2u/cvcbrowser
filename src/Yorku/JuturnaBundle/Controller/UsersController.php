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
 * <summary>This file is created for Users controller with bundle YorkuJuturnaBundle</summary>
 * <purpose>all Users entity related actions process in this controller</purpose>
 */

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yorku\JuturnaBundle\Entity\Users;
use Yorku\JuturnaBundle\Form\UsersType;
use Doctrine\DBAL\Types\Type;

Type::overrideType('datetime', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('datetimetz', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('time', 'Doctrine\DBAL\Types\VarDateTimeType');

/**
 * Users controller.
 *
 * @Route("/users")
 */
class UsersController extends Controller {

    /**
     * Lists all Users entities.
     *
     * @Route("/", name="users")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {

        $request = $this->getRequest();
        if (true === $request->isXmlHttpRequest()) {
            $conn = $this->get('database_connection');
            $users = $conn->fetchAll("SELECT id,username,firstname,phone,lastname,email,address,postal_code,created_at,updated_at, status, reason FROM users");
            return new JsonResponse(array(
                'data' => $users
            ));
        }
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('YorkuJuturnaBundle:Users')->findAll();
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Users entity.
     *
     * @Route("/", name="users_create")
     * @Method("POST")
     * @Template("YorkuJuturnaBundle:Users:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Users();
        $form = $this->createForm(new UsersType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('users_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Users entity.
     *
     * @Route("/new", name="users_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Users();
        $form = $this->createForm(new UsersType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * resetpassword user account password.
     *
     * @Route("/resetpassword", name="users_resetpassword")
     * @Method("POST")
     * @Template()
     */
    public function resetpasswordAction() {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $json = $request->get('user');
        $data = json_decode($json, true);

        /*      $qb = $em->getRepository('YorkuJuturnaBundle:Users')->createQueryBuilder('u') ;

          $user =$qb->select('u')
          ->where(
          $qb->expr()->orx(
          $qb->expr()->like('u.username' ,':username') ,
          $qb->expr()->like('u.email' ,':username')
          )
          )
          //->andWhere($qb->expr()->eq('u.enabled' ,'true') )
          ->setParameters(array('username' =>$data['username'] ) )
          ->getQuery()
          ->getResult() ;
         */

        $user = $this->getDoctrine()->getManager()
                ->createQuery('SELECT u FROM
         YorkuJuturnaBundle:Users u
         WHERE u.username = :username
         OR u.email = :username')
                ->setParameters(array(
                    'username' => $data['username']
                ))
                ->getOneOrNullResult();





        //      $user = $em->getRepository('YorkuJuturnaBundle:Users')->findByUsernameOrEmail($data['username']);
        if ($user) {
            $password = $this->createpassword();
            $manipulator = $this->get('fos_user.util.user_manipulator');
            $manipulator->changePassword($user->getUsername(), $password);

            $message = \Swift_Message::newInstance()
                    ->setSubject('Juturna account password reset')
                    ->setFrom('bunchmj@yorku.ca')
                    ->setTo($user->getEmail())
                    ->setBody($this->renderView('YorkuJuturnaBundle:Admin:success_resetpassword.html.twig', array('username' => $user->getUsername(), 'email' => $user->getEmail(), 'password' => $password)), 'text/html')
            ;

            $this->get('mailer')->send($message);

            return new JsonResponse(array(
                'success' => false,
                'message' => "Password has been successfully reset,please check your email!"
            ));
        } else {
            return new JsonResponse(array(
                'success' => false,
                'message' => "user account " . $data['username'] . " doesn't exist!"
            ));
        }
    }

    /**
     * Change user account password.
     *
     * @Route("/changepassword", name="users_changepassword")
     * @Method("POST")
     * @Template()
     */
    public function changepasswordAction() {
        $user = $this->getUser();
        if ($user) {
            $request = $this->getRequest();
            $json = $request->get('user');
            $data = json_decode($json, true);

            $password = $data['oldpassword'];
            if ($data['oldpassword'] == '' || $data['oldpassword'] == null) {
                return new JsonResponse(array(
                    'success' => false,
                    'message' => "You must provide current account password."
                ));
            }
            if ($data['password'] != $data['password_confirmation']) {
                return new JsonResponse(array(
                    'success' => false,
                    'message' => "New password and password confirmation doesn't march!"
                ));
            }

            return $this->matchPassword($user, $password, $data);

        } else {
            return new JsonResponse(array(
                'success' => false,
                'message' => "for changing user password, You must login first."
            ));
        }
    }

    private function matchPassword($user, $password, $data) {
        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);
        $encoded_pass = $encoder->encodePassword($password, $user->getSalt());
        if ($encoded_pass === $user->getPassword()) {
            $manipulator = $this->get('fos_user.util.user_manipulator');
            $manipulator->changePassword($user->getUsername(), $data['password']);
            return new JsonResponse(array(
                'success' => false,
                'message' => "Password has been successfully changed!"
            ));
        } else {
            return new JsonResponse(array(
                'success' => false,
                'message' => "Current password is not correct!"
            ));
        }
    }

    /**
     * Finds and displays a Users entity.
     *
     * @Route("/{id}", name="users_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Users')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Users entity.
     *
     * @Route("/{id}/edit", name="users_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Users')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }

        $editForm = $this->createForm(new UsersType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Users entity.
     *
     * @Route("/{id}", name="users_update")
     * @Method("PUT")
     * @Template("YorkuJuturnaBundle:Users:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('YorkuJuturnaBundle:Users')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UsersType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('users_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Users entity.
     *
     * @Route("/destroy", name="users_destroy")
     * @Method("POST")
     */
    public function destroyAction(Request $request) {
        $id = $request->get("id");
        if ($id != null && $id != '') {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('YorkuJuturnaBundle:Users')->find($id);

            if (!$entity) {
                return new JsonResponse(array(
                    'success' => true,
                    'message' => "Unable to find Users entity!"
                ));
            }
            $em->remove($entity);
            $em->flush();
            return new JsonResponse(array(
                'success' => true,
                'message' => "Account successfully deleted!"
            ));
        } else {
            return new JsonResponse(array(
                'success' => true,
                'message' => "invalid user id number!"
            ));
        }
    }

    /**
     * Deletes a Users entity.
     *
     * @Route("/{id}", name="users_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('YorkuJuturnaBundle:Users')->find($id);
        if (true === $request->isXmlHttpRequest()) {
            if (!$entity) {
                return new JsonResponse(array('success' => true, 'message' => "Unable to find Users entity!"));
            }
            $em->remove($entity);
            $em->flush();
            return new JsonResponse(array('success' => true, 'message' => "Account successfully deleted!"));
        } else {
            $form = $this->createDeleteForm($id);
            $form->bind($request);
            if ($form->isValid()) {
                $this->removeUser($em, $entity);
            }
            return $this->redirect($this->generateUrl('users'));
        }
    }

    /**
     * Creates a form to delete a Users entity by id.
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

    private function createpassword($length = 6) {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    /**
     * 
     * @param Entitymanager $em
     * @param Entity $entity
     * @throws type
     */
    private function removeUser($em, $entity) {
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $em->remove($entity);
        $em->flush();
    }

}

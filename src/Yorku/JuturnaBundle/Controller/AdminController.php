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
 * <summary>This file is created for admin controller with bundle YorkuJuturnaBundle</summary>
 * <purpose>all admin actions process in this controller except the sonata admin dashboard</purpose>
 */

namespace Yorku\JuturnaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\DBAL\Types\Type;
use Yorku\JuturnaBundle\Entity\Users;

Type::overrideType('datetime', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('datetimetz', 'Doctrine\DBAL\Types\VarDateTimeType');
Type::overrideType('time', 'Doctrine\DBAL\Types\VarDateTimeType');

/**
 * Stations controller.
 *
 * @Route("/sysadmin")
 */
class AdminController extends Controller {

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/", name="admin_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = null; // $em->getRepository('YorkuJuturnaBundle:BenthicCollections')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/storyimage", name="admin_storyimage")
     * @Method("GET")
     * @Template()
     */
    public function storyimageAction() {
        $em = $this->getDoctrine()->getManager();
        $source_dir = $this->get('kernel')->getRootDir() . '/../web/uploads/stories/';
        $conn = $this->get("database_connection");
        $entities = $conn->fetchAll("select * from stories"); // $em->getRepository('YorkuJuturnaBundle:Story')->findAll();
        foreach ($entities as $entity) {
            $uid = $entity['uid'];
            $id = $entity['id'];
            if (file_exists($source_dir . $uid)) {
                rename($source_dir . $uid, $source_dir . $id);
            }
        }
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all admin userprofile.
     *
     * @Route("/userprofile", name="admin_userprofile")
     * @Method("GET")
     * @Template()
     */
    public function userprofileAction() {
//     $em = $this->getDoctrine()->getManager();
//     $entities = $em->getRepository('YorkuJuturnaBundle:Roles')->findAll();

        $conn = $this->get('database_connection');

        $roles = null; //$conn->fetchAll("SELECT  * FROM roles  order by name");

        return new JsonResponse(array(
            'data' => $roles
        ));
    }

    /**
     * Lists all BenthicCollections entities.
     *
     * @Route("/javascript", name="admin_javascript")
     * @Method("GET")
     * @Template()
     */
    public function javascriptAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $logos = $em->getRepository('YorkuJuturnaBundle:Logo')->findBy(array('enabled' => true), array("showSeq" => 'ASC'));
        $systemparams = $em->getRepository('YorkuJuturnaBundle:Systemparams')->findAll();

        if ($systemparams) {
            $systemparam = $systemparams[0];
        } else {
            $systemparam = null;
        }
        return array('logos' => $logos, 'systemparams' => $systemparams);
    }

    /**
     * Displays a form to create a new Benthics entity.
     *
     * @Route("/systemparams", name="admin_systemparams")
     * @Method("GET")
     * @Template()
     */
    public function systemparamsAction() {
//   $em = $this->getDoctrine()->getManager();
//   $entities = $em->getRepository('YorkuJuturnaBundle:Benthics')->findAll();

        return array();
    }

    /**
     * Displays a form to create a new Benthics entity.
     *
     * @Route("/systembackup", name="admin_systembackup")
     * @Method("GET")
     * @Template()
     */
    public function systembackupAction() {
//   $em = $this->getDoctrine()->getManager();
//   $entities = $em->getRepository('YorkuJuturnaBundle:Benthics')->findAll();

        $databaseform = $this->createFormBuilder()
                ->add('database_folder', 'text', array('label' => '', 'data' => 'database'
                ))
                ->add('database_file', 'text', array('label' => '', 'data' => 'databasebackup_' . date('Y-m-d_H_i_s')
                ))
                ->add('database_schedule', 'checkbox', array('label' => 'Backup on Schedule:',
                ))
                ->add('database_backuptime', 'choice', array('label' => '',
                    'choices' => array('Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly')
                ))
                ->getForm();

        $systemform = $this->createFormBuilder()
                ->add('system_folder', 'text', array('label' => '', 'data' => 'system'
                ))
                ->add('system_file', 'text', array('label' => '', 'data' => 'systembackup_' . date('Y-m-d_H_i_s')
                ))
                ->add('system_schedule', 'checkbox', array('label' => 'Backup on Schedule:',
                ))
                ->add('system_backuptime', 'choice', array('label' => '',
                    'choices' => array('Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly')
                ))
                ->getForm();


        return array("databaseform" => $databaseform->createView(), "systemform" => $systemform->createView());
    }

    // check the uploaded shapefile and if the assigned content field name exist or not
    private function isColumnExist($conn, $tablename, $columnname) {

        $sql = "SELECT column_name FROM information_schema.columns WHERE table_name=:tablename and column_name=:column_name";

        //    $sql = "SELECT st_srid(the_geom) as srid , box(the_geom) as bounds, st_astext(st_centroid(the_geom)) as the_geom FROM manifold_geoms WHERE userboundary_id=:userboundary_id  and ogc_fid=:ogc_fid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tablename', $tablename);
        $stmt->bindParam(':column_name', $columnname); //PDO::PARAM_STR, 12);
        $stmt->execute();

//    $sql = "SELECT st_srid(the_geom) as srid , box(the_geom) as bounds, st_astext(st_centroid(the_geom)) as the_geom FROM manifold_geoms WHERE userboundary_id=" . $userboundary_id . ' and ogc_fid=' . $ogc_fid;
        $stmt_result = $stmt->fetchAll();

        $rowCount = count($stmt_result);
        if ($rowCount == 0) {
            return "Sorry,the watershed field name:" . $columnname . " is not found in shape file!";
        } else {
            return false;
        }
    }

    /*
     *   input parameter
     *   $epsg_name like EPSG:4326 or 4326
     *   $project_file line /shapfiles/testshapefile.prj
     *   return array with epsg and error variable
     */

    private function checkEPSG($epsg_name, $project_file) {
        $epsg_number = 0;
        $errors = array();
        if ($epsg_name !== null && $epsg_name !== '' && !empty($epsg_name)) {

            $conn = $this->get('database_connection');

            $epsg_name = strtoupper($epsg_name);
            $pos = strrpos($epsg_name, "EPSG:");
            if ($pos === false) {
                // EPSG number not found
                $epsg_number = intval($epsg_name);
                $sql = "select count(*) as count from spatial_ref_sys where auth_name='EPSG' and auth_srid=$epsg_number";
                $stmt = $conn->query($sql); // Simple, but has several drawbacks
                $row = $stmt->fetch();
                if ($row['count'] == 0) {
                    array_push($errors, "Defined EPSG number " . $epsg_number . " not found!");
                    $epsg_number = 0;
                    //           return array("epsg"=>$epsg_number,"error" => "Defined EPSG number not found!");
                }
            } else {
                $epsg_name = substr($epsg_name, $pos + 5);
                $epsg_number = intval($epsg_name);
                $sql = "select count(*) as count from spatial_ref_sys where auth_name='EPSG' and auth_srid=:epsg_number";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':epsg_number', $epsg_number);

                $stmt->execute();
                $row = $stmt->fetch();
                if ($row['count'] == 0) {

                    array_push($errors, "Defined EPSG number " . $epsg_number . " not found!");
                    $epsg_number = 0;
                    //           return array("epsg"=>$epsg_number,"error" => "Defined EPSG number not found!");
                }
            }
        }
        if ($epsg_number === 0 && ( $project_file === null || $project_file === '' || empty($project_file))) { // if user didn't input EPSG number and not upload projection file
            array_push($errors, "No projection file defined!");
            //     return array("epsg"=>$epsg_number,'error' => 'No EPSG number and projection file defined!');
        } else {

            // check if projection uploaded
            if ($epsg_number === 0 && $project_file != null) {
                $jsontext = file_get_contents($project_file);
                $i = strpos($jsontext, 'GEOGCS[');
                if ($i !== FALSE) {
                    $jsontext = substr($jsontext, $i);
                    $i = strpos($jsontext, ']],');
                    $jsontext = substr($jsontext, 0, $i + 2);

                    $sql = "select srid from spatial_ref_sys where srtext like '%:jsontext%'";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':jsontext', $jsontext);

                    $stmt->execute();
                    $stmt_result = $stmt->fetchAll();
                    if (sizeof($stmt_result) == 0) {
                        array_push($errors, "EPSG number not found by projection file!");
                        //                     return array("epsg"=>$epsg_number,"error" => "EPSG number not found by projection file!");
                    } else {
                        $epsg_number = $stmt_result[0]['srid'];
                    }
                }
            }
            return array("epsg" => $epsg_number, "errors" => $errors);
        }
    }

}

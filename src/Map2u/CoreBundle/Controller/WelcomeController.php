<?php

namespace Map2u\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Yorku\JuturnaBundle\Entity\BirdObservation;
use Yorku\JuturnaBundle\Entity\BreedingStatus;
use Yorku\JuturnaBundle\Entity\IUCN;
use Yorku\JuturnaBundle\Entity\ObservationDescription;
use Yorku\JuturnaBundle\Entity\Rareness;
use Yorku\JuturnaBundle\Entity\Season;
use Yorku\JuturnaBundle\Entity\Species;
use Yorku\JuturnaBundle\Entity\Station;
use Yorku\JuturnaBundle\Entity\Distribution;

/**
 * Welcome controller.
 *
 * @Route("/welcome")
 */
class WelcomeController extends Controller {

  /**
   * show welcome page.
   *
   * @Route("/", name="welcome_index")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Request $request) {

    $em = $this->getDoctrine()->getManager();
    $_locale = $request->attributes->get('_locale', $request->getLocale());

    $logos = $em->getRepository('YorkuJuturnaBundle:Logo')->findBy(array('enabled' => true), array("showSeq" => 'ASC'));
    $systemparams = $em->getRepository('YorkuJuturnaBundle:Systemparams')->findAll();

    if ($systemparams) {
      $systemparam = $systemparams[0];
    }
    else {
      $systemparam = null;
    }

    $twig = $this->container->get("twig");
    $twig->addGlobal("logos", $logos);

    //  return array('logos' => $logos, 'systemparams' => $systemparams);
    return $this->render('Map2uCoreBundle:Welcome:index.html.twig', array('_locale' => $_locale));
  }

  public function headerAction() {

    $em = $this->getDoctrine()->getManager();
    $request = $this->getRequest();
    $logos = $em->getRepository('YorkuJuturnaBundle:Logo')->findBy(array('enabled' => true), array("showSeq" => 'ASC'));
    $systemparams = $em->getRepository('YorkuJuturnaBundle:Systemparams')->findAll();
    $_locale = $request->attributes->get('_locale', $request->getLocale());

    if ($systemparams) {
      $systemparam = $systemparams[0];
    }
    else {
      $systemparam = null;
    }
    $locale_menu_img = $request->get('locale_menu_img');
    $twig = $this->container->get("twig");
    $twig->addGlobal("logos", $logos);

    return $this->render('Map2uCoreBundle:Welcome:header.html.twig', array('locale_menu_img' => $locale_menu_img,'_locale'=>$_locale));
  }

  public function header_logosAction() {

    $em = $this->getDoctrine()->getManager();

    $logos = $em->getRepository('YorkuJuturnaBundle:Logo')->findBy(array('enabled' => true), array("showSeq" => 'ASC'));
    $systemparams = $em->getRepository('YorkuJuturnaBundle:Systemparams')->findAll();

    if ($systemparams) {
      $systemparam = $systemparams[0];
    }
    else {
      $systemparam = null;
    }

    $twig = $this->container->get("twig");
    $twig->addGlobal("logos", $logos);

    return $this->render('Map2uCoreBundle:Welcome:header_logos.html.twig');
  }
  public function loginformjsAction() {
    return $this->render('Map2uCoreBundle:Welcome:loginformjs.html.twig');
  }

  public function footerAction() {
    return $this->render('Map2uCoreBundle:Welcome:footer.html.twig');
  }

  /**
   * show welcome page.
   *
   * @Route("/init", name="welcome_init")
   * @Method("GET")
   * @Template()
   */
  public function initAction(Request $request) {
    $password = $request->get('password');
    if (isset($password) && ($password === '135246')) {


      $dir = $this->get('kernel')->getRootDir() . "/../src/Yorku/JuturnaBundle/Resources/data";



      $conn = $this->get('database_connection');
//echo var_dump($dir);

      $sql = "TRUNCATE stations_species,birds_geometry,birds,station,bird_species,bird_season,bird_rareness,bird_breedingstatus,bird_observationdescription,bird_observation,bird_iucn ,bird_distribution  RESTART IDENTITY";
 //     $sql = "TRUNCATE birds_geometry,birds,station  RESTART IDENTITY";
      $stmt = $conn->query($sql);
//return $this->redirect("/createpdf"); 
      $manager = $this->getDoctrine()->getManager();

      $this->loadStationData($dir, $manager); // load station name and code
      $this->loadSpeciesData($dir, $manager); // load species name and description
      $this->loadIUCNData($dir, $manager); // load IUCN and code
      $this->loadSeasonData($dir, $manager); // load season name and code
      $this->loadRarenessData($dir, $manager); // load rareness name and code
      $this->loadBreedingStatusData($dir, $manager); // load breeding status name and code
      $this->loadObservationDescriptionData($dir, $manager);  // load breeding status observation description
      $this->loadBirdObservationData($dir, $manager); // load observations
      $this->loadDistributionData($dir, $manager); // load distribution data
     
//      $logos = $em->getRepository('YorkuJuturnaBundle:Logo')->findBy(array('enabled' => true), array("showSeq" => 'ASC'));

      return array("test" => '123');
    }

    return $this->redirect("/");
  }

  private function loadSeasonData($dir, $manager) {
    $filepath = $dir . '/Season/Season.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new Season();
        $srs->setCode($temp[0]);
        if (isset($temp[1])) {
          $srs->setSeasonName($temp[1]);
        }
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }

  private function loadRarenessData($dir, $manager) {
    $filepath = $dir . '/Rareness/Rareness.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new Rareness();
        $srs->setCode($temp[0]);
        if (isset($temp[1]))
          $srs->setRarenessName($temp[1]);
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }

  private function loadStationData($dir, $manager) {
    $filepath = $dir . '/Station/Station.txt';

    if (file_exists($filepath)) {

      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        $temp[2]=trim($temp[2]);
        if ($temp[2] === null || strlen($temp[2]) === 0) {
          continue;
        }
        $srs = new Station();
        $srs->setCode($temp[2]);
        if (isset($temp[3]))
          $srs->setStationName(trim($temp[3]));
        if (isset($temp[0]))
          $srs->setLng(floatval(trim($temp[0])));
        if (isset($temp[1]))
          $srs->setLat(floatval(trim($temp[1])));
        
        $manager->persist($srs);
        //     $this->loadBirdObservation(strtolower($temp[0]), $manager);
      }
      $manager->flush();
      fclose($file);
    }
  }

  private function loadSpeciesData($dir, $manager) {
    $filepath = $dir . '/Species/Species.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new Species();
        $srs->setSpeciesName(str_ireplace('"', '', $temp[0]));
        if (isset($temp[1]))
          $srs->setDescription(str_ireplace('"', '', $temp[1]));
        if (isset($temp[2]))
          $srs->setIUCN(str_ireplace('"', '', $temp[2]));
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }

  private function loadBreedingStatusData($dir, $manager) {
    $filepath = $dir . '/BreedingStatus/BreedingStatus.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new BreedingStatus();
        $srs->setCode(trim($temp[0]));
        if (isset($temp[1]))
          $srs->setName(trim($temp[1]));
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }

  private function loadObservationDescriptionData($dir, $manager) {
    $filepath = $dir . '/ObservationDescription/ObservationDescription.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new ObservationDescription();
        $srs->setCode(trim($temp[0]));
        if (isset($temp[1]))
          $srs->setName(trim($temp[1]));
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }

  private function loadBirdObservationData($dir, $manager) {


    $stations = $manager->getRepository('YorkuJuturnaBundle:Station')->findAll();
    foreach ($stations as $station) {
      $filepath = $dir . '/BirdObservation/' . strtolower($station->getCode()) . '.txt';

      if (file_exists($filepath)) {
        $file = @fopen($filepath, "r");
        $help1 = trim(str_ireplace("\n", "", fgets($file)));
        $temp1 = explode(";;", $help1);
        $help2 = trim(str_ireplace("\n", "", fgets($file)));
        $temp2 = explode(";;", $help2);

        while (!feof($file)) {
          $help = trim(str_ireplace("\n", "", fgets($file)));
          if (strlen($help) === 0) {
            continue;
          }
          $temp = explode(";;", $help);

          $temp[0] = str_ireplace('"', '', $temp[0]);
          if(strlen($temp[0])>0)
             $temp[0] = trim($temp[0]);
          
          if ($temp[0] !== null && strlen($temp[0]) !== 0) {

            $species = $manager->getRepository("YorkuJuturnaBundle:Species")->findOneBy(array('speciesName' => $temp[1]));
            if (!$species) {
              $species = new Species();
              $species->setCode(trim($temp[0]));
              $species->setSpeciesName(trim($temp[1]));
            }
            //     $species->addStation($station);
            //     $manager->persist($species);
            if ($station->getSpecies() === null) {
              echo "test3<br>";
              $station->addSpecie($species);
              $manager->persist($species);
            }
            else {
              $stationspecies = $station->getSpecies();
              echo "test1<br>";
              if ($stationspecies->contains($species) === false) {
                echo "test2<br>";
                $station->addSpecie($species);
                $manager->persist($species);
              }
              else {
                echo "test4<br>";
              }
            }
            for ($i = 2; $i < count($temp1); $i++) {

              if ($temp[$i] !== '-' && $temp[$i] !== '_') {

                $srs = new BirdObservation();
                $srs->setSpecies($species); // set the observation species
                $this->get('logger')->debug("SpeciesName=" . $species->getSpeciesName());
                $srs->setStation($station);


                $ob = $manager->getRepository("YorkuJuturnaBundle:BreedingStatus")->findOneBy(array('code' => $temp[$i][0]));
                if ($ob) {
                  $srs->setBreedingStatus($ob); // set the observation breeding status
                  //    $obs=[];
                  //    for($j=1;$j<count($temp[$i]);$j++)
                  //    {
                  //      $observationDescription=$em->getRepository("YorkuJuturnaBundle:ObservationDescription")->findOneBy(array('code'=>$temp[$i][$j]));
                  //      if($observationDescription)
                  //        array_push($obs,$observationDescription);
                  //    }
                  $this->get('logger')->debug("ObservationDescription=" . $temp[$i]);

                  //      echo $temp[$i] . "<br>";
                  //      echo date('Y-m-d', strtotime($temp1[$i])) . "<br>";

                  $srs->setObservationDescription(substr($temp[$i], 1));
                  $time = trim(str_ireplace('"', "", $temp1[$i]));
                  if ($time != '') {
                    $currentTime = new \DateTime($temp1[$i]);
                    var_dump($currentTime);
                    $srs->setObservedAt($currentTime);
                  }

                  $manager->persist($srs);
                }
              }
            }
          }
        }
        $manager->flush();
        fclose($file);
      }
    }
  }

  private function loadIUCNData($dir, $manager) {
    $filepath = $dir . '/IUCN/IUCN.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new IUCN();
        $srs->setCode($temp[0]);
        if (isset($temp[1]))
          $srs->setIUCNName($temp[1]);
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }
    private function loadDistributionData($dir, $manager) {
    $filepath = $dir . '/Distribution/Distribution.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode(';;', $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new Distribution();
        $srs->setCode($temp[0]);
        if (isset($temp[1]))
          $srs->setDistributionName($temp[1]);
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
    
  }

}

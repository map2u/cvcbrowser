<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//	DATE	22/08/2007	13/09/2007	25/09/2007	04/10/2007	17/10/2007	26/10/2007	07/11/2007	20/11/2007	29/11/2007	12/6/2007	1/11/2008	21/01/2008	31/01/2008	2/11/2008	2/19/2008	10/03/2008	3/28/2008	
 //CODE	SPECIES NAME/PERIOD	1	2	3	4	5	6	7	8	9	10	11	12	13	14	15	16	17	
namespace Yorku\JuturnaBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Yorku\JuturnaBundle\Entity\BreedingStatus;

/**
 * The LoadSpeciesData loads the Species parameter from a text file into a database table.
 * 
 * @author Joseph Zhao
 */
class LoadBreedingStatusData implements FixtureInterface {

  /**
   * @inheritdoc
   */
  public function load(ObjectManager $manager) {
    $filepath = __DIR__ . '/../../../Resources/data/BreedingStatus/BreedingStatus.txt';
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
        $srs->setCode($temp[0]);
        if(isset($temp[1]))
          $srs->setName($temp[1]);
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }
}

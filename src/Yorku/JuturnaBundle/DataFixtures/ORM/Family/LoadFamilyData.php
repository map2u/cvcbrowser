<?php

namespace Yorku\JuturnaBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Yorku\JuturnaBundle\Entity\Family;

/**
 * The LoadFamilyData loads the family parameter from a text file into a database table.
 * 
 * @author Joseph Zhao
 */
class LoadFamilyData implements FixtureInterface {

  /**
   * @inheritdoc
   */
  public function load(ObjectManager $manager) {
    $filepath = __DIR__ . '/../../../Resources/data/Family/family.txt';
    if (file_exists($filepath)) {
      $file = @fopen($filepath, "r");
      while (!feof($file)) {
        $help = trim(str_ireplace("\n", "", fgets($file)));
        if (strlen($help) === 0) {
          continue;
        }
        $temp = explode("|", $help);
        if ($temp[0] === null || strlen($temp[0]) === 0) {
          continue;
        }
        $srs = new Family();
        $srs->setFamilyName($temp[0]);
        $srs->setDescription($temp[1]);
        $manager->persist($srs);
      }
      $manager->flush();
      fclose($file);
    }
  }
}

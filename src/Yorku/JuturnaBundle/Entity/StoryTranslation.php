<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Sonata Project <https://github.com/sonata-project/SonataClassificationBundle/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yorku\JuturnaBundle\Entity;

use Map2u\CoreBundle\Entity\BaseStoryTranslation;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

class StoryTranslation extends BaseStoryTranslation {

   use ORMBehaviors\Translatable\Translation;

}

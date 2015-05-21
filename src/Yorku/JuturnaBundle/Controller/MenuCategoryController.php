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
 * <date>created at 2014/01/07</date>
 * <date>last updated at 2015/05/21</date>
 * <summary>This file is surposed for user to create,update,delete and list system menu</summary>
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Yorku\JuturnaBundle\Entity\TourismGeoms;
use Yorku\JuturnaBundle\Entity\TourismComments;
use Yorku\JuturnaBundle\Form\TourismCommentsType;
use Yorku\JuturnaBundle\Form\TourismGeomsType;
use Yorku\JuturnaBundle\Entity\Tourism;
use Yorku\JuturnaBundle\Form\TourismType;
use CrEOF\Spatial\ORM\Query\AST\Functions\PostgreSql\STGeomFromText;
use CrEOF\Spatial\PHP\Types\Geometry\GeometryInterface;
use CrEOF\Spatial\Tests\DBAL\Types\Geometry;



/**
 * Stations controller.
 *
 * @Route("/menucategory")
 */
class MenuCategoryController extends Controller {

    /**
     * .
     *
     * @Route("/", name="menucategory_index", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        $categorycontents = null;
        $_locale = $request->attributes->get('_locale', $request->getLocale());
        $layerId = $request->get('layerid');
        $contentId = $request->get('content_id');
        $categorySlug = $request->get('category');
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('YorkuJuturnaBundle:Category')->findOneBy(array('slug' => $categorySlug));
        if ($category) {
            if(intval($layerId)==0)
                $categorycontents = $em->getRepository('YorkuJuturnaBundle:CategoryContents')->findBy(array('id' => $contentId, 'category' => $category), array('position' => 'ASC'));
            else
                $categorycontents = $em->getRepository('YorkuJuturnaBundle:CategoryContents')->findBy(array('layerId' => $layerId, 'category' => $category), array('position' => 'ASC'));
        }

        return array('_locale' => $_locale, 'categorycontents' => $categorycontents,'category'=>$category);
    }

}

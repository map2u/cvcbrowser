<?php

namespace Yorku\JuturnaBundle\Controller;

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

#use Map2u\CoreBundle\Classes\GeoJSON;

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

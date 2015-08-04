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
 * <summary>This is the extend of Sonata\NewsBundle\Entity\CommentManager entity</summary>
 * <purpose>for entity extend based on Sonata\NewsBundle\Entity\CommentManager</purpose>
 */

namespace Application\Sonata\NewsBundle\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;
use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\NewsBundle\Model\CommentInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sonata\NewsBundle\Model\CommentManagerInterface;
use Sonata\NewsBundle\Model\PostInterface;
use Sonata\DoctrineORMAdminBundle\Datagrid\Pager;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\NewsBundle\Entity\CommentManager as baseCommentManager;

class CommentManager extends baseCommentManager {

    /**
     * @param array   $criteria
     * @param integer $page
     * @param integer $maxPerPage
     *
     * @return \Sonata\AdminBundle\Datagrid\PagerInterface
     */
    public function getPager(array $criteria, $page, $limit = 10, array $sort = array()) {
        if (!isset($criteria['mode'])) {
            $criteria['mode'] = 'public';
        }

        $parameters = array();

        $query = $this->getRepository()->createQueryBuilder('c');


        if ($criteria['mode'] == 'public') {
            $criteria['status'] = isset($criteria['status']) ? $criteria['status'] : CommentInterface::STATUS_VALID;
            $query->andWhere('c.status = :status');
            $parameters['status'] = $criteria['status'];
        }

        if (isset($criteria['postId'])) {
            $query->andWhere('c.post = :postId');
            $parameters['postId'] = $criteria['postId'];
        }

        $query->setParameters($parameters);

        $pager = new Pager();
        $pager->setMaxPerPage($limit);

        $pager->setQuery($this->proxyQuery($query));
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    private function proxyQuery($query) {
        $proxyQuery = new ProxyQuery($query);
        $proxyQuery->setSortBy(array(), array('fieldName' => 'createdAt'));
        $proxyQuery->setSortOrder('DESC');
        return $proxyQuery;
    }

}

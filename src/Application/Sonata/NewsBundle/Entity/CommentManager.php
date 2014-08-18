<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

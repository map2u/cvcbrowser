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

use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Sonata\CoreBundle\Model\BaseEntityManager;
use Sonata\DoctrineORMAdminBundle\Datagrid\Pager;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\NewsBundle\Model\BlogInterface;
use Sonata\NewsBundle\Model\PostInterface;
use Sonata\NewsBundle\Model\PostManagerInterface;
use Sonata\NewsBundle\Entity\PostManager as basePostManager;

class PostManager extends basePostManager
{
    /**
     * {@inheritdoc}
     */
    public function getPager(array $criteria, $page, $maxPerPage = 10)
    {
        if (!isset($criteria['mode'])) {
            $criteria['mode'] = 'public';
        }
        $parameters = array();
        $query = $this->getRepository()
            ->createQueryBuilder('p')
            ->select('p,t');
        if ($criteria['mode'] == 'admin') {
            $query
                ->leftJoin('p.tags', 't')
                ->leftJoin('p.author', 'a')
            ;
        } else {
            $query
                ->leftJoin('p.tags', 't', Join::WITH, 't.enabled = true')
                ->leftJoin('p.author', 'a', Join::WITH, 'a.enabled = true')
            ;
        }

        if ($criteria['mode'] == 'public') {
            // enabled
            $criteria['enabled'] = isset($criteria['enabled']) ? $criteria['enabled'] : true;
            $query->andWhere('p.enabled = :enabled');
            $parameters['enabled'] = $criteria['enabled'];
        }

        if (isset($criteria['date'])) {
            $query->andWhere($criteria['date']['query']);
            $parameters = array_merge($parameters, $criteria['date']['params']);
        }

        if (isset($criteria['tag'])) {
            $query->andWhere('t.slug LIKE :tag');
            $parameters['tag'] = (string) $criteria['tag'];
        }

        if (isset($criteria['author'])) {
            if (!is_array($criteria['author']) && stristr($criteria['author'], 'NULL')) {
                $query->andWhere('p.author IS '.$criteria['author']);
            } else {
                $query->andWhere(sprintf('p.author IN (%s)', implode((array) $criteria['author'], ',')));
            }
        }

        if (isset($criteria['collection']) && $criteria['collection'] instanceof CollectionInterface) {
            $query->andWhere('p.collection = :collectionid');
            $parameters['collectionid'] = $criteria['collection']->getId();
        }
        $query->setParameters($parameters);

        $pager = new Pager();
        $pager->setMaxPerPage($maxPerPage);
        $proxyQuery = new ProxyQuery($query);
       
      
        $proxyQuery->setSortBy(array(),array('fieldName'=>'publicationDateStart'));
        $proxyQuery->setSortOrder('DESC');
       
        $pager->setQuery($proxyQuery);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }
}

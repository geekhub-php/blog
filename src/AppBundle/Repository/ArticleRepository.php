<?php


namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;


class articleRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLatestArticles($limit = null)
    {
        $qb = $this->createQueryBuilder('a')
                   ->select('a', 'c')
                   ->leftJoin('a.comments', 'c')
                   ->addOrderBy('a.date', 'DESC');

        if (false === is_null($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()
                  ->getResult();
    }

}

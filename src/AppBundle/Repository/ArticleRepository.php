<?php

namespace AppBundle\Repository;

class articleRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLatestArticles($limit = null)
    {
        $qb = $this->createQueryBuilder('a')
                   ->select('a')
                   ->addOrderBy('a.date', 'DESC');

        if (false === is_null($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()
                  ->getResult();
    }
}

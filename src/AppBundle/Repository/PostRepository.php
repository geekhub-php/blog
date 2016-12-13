<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPostsList()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('p')
            ->from('AppBundle:Post', 'p')
            ->where('p.visibility = 1')
            ->orderBy('p.createAt', 'DESC');

        return $query->getQuery()->getResult();
    }
}
<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllOrderByDesc()
    {
        return $this->createQueryBuilder('post')
            ->addOrderBy('post.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

}

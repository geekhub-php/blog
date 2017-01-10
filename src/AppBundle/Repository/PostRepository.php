<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return \Doctrine\ORM\Query
     */
    public function findAllPosts()
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.dateCreated', 'DESC')
            ->getQuery();

        return $query;
    }
}

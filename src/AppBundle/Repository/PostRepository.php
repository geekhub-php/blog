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

    public function findAllByCategory($categoryId)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.category = :category')
            ->setParameter('category', $categoryId)
            ->orderBy('p.dateCreated', 'DESC')
            ->getQuery();

        return $query;
    }

    /**
     * @param int $tagId
     *
     * @return \Doctrine\ORM\Query
     */
    public function findAllByTag($tagId)
    {
        $query = $this->createQueryBuilder('p')
            ->innerJoin('p.tags', 't', 'WITH', 't.id = :tagId')
            ->setParameter('tagId', $tagId)
            ->orderBy('p.dateCreated', 'DESC')
            ->getQuery();

        return $query;
    }
}

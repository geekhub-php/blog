<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    public function findAllOrdered()
    {
        $qb = $this->createQueryBuilder('article')
            ->addOrderBy('article.createdAt', 'DESC');
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function findByAuthor($author)
    {
        $qb = $this->createQueryBuilder('comment')
            ->andWhere('comment.author = :author')
            ->setParameter('author', $author);

        return $qb->getQuery()->execute();
    }
}

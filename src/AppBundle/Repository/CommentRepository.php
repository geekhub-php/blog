<?php

namespace AppBundle\Repository;

class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCommentForArticle($articleId)
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('c')
                   ->where('c.article = :article_id')
                   ->setParameter('article_id', $articleId);

        return $qb->getQuery()
                  ->getResult();
    }

    public function getLatestComments($limit = 5)
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('c')
                   ->addOrderBy('c.id', 'DESC');

        if (false === is_null($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}

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
}

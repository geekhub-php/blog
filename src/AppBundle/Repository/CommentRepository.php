<?php

namespace AppBundle\Repository;


class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCommentsByPost($id) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $comments = $qb->select('c')
            ->from('AppBundle:Comment', 'c')
            ->where('c.posts = ' . $id)
            ->orderBy('c.createdAt', 'DESC');

        return $comments->getQuery()->getResult();
    }
}
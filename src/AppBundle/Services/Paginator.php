<?php

namespace AppBundle\Services;

use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class Paginator
{
    /**
     * Paginator Helper
     *
     * @param \Doctrine\ORM\Query $dql   DQL Query Object
     * @param integer             $page  Current page (defaults to 1)
     * @param integer             $limit The total number per page (defaults to 5)
     *
     * @return array
     */
    public function paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new DoctrinePaginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        $maxPages = ceil($paginator->count() / $limit);
        $thisPage = $page;

        return array(
            'items'     => $paginator,
            'maxPages'  => $maxPages,
            'thisPage'  => $thisPage
        );
    }
}

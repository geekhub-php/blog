<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/posts/all", name="all_posts")
     * @Template()
     *
     * @return array;
     */
    public function getAllAction(Request $request, $page = 1)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($repository->findAll(),
            $request->query->getInt('page', $page), 5
        );

        return $this->render('AppBundle:Post:getAll.html.twig', [
            'posts' => $pagination,
        ]);
    }

    /**
     * @Route("/findByCategory/{category}", name="findByCategory")
     * @Template()
     *
     * @param string $category;
     *
     * @return array;
     */
    public function findByCategoryAction($category)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $posts = $repository->createQueryBuilder('p')
            ->innerJoin('p.category', 'c')
            ->andWhere('c.name = :category ')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();

        return array('posts' => $posts);
    }
}

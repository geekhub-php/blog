<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * Show posts from category
     *
     * @Route("/category/{id}/{page}", name="category_post", requirements={"id": "\d+", "page": "\d+"} )
     * @Template()
     * @Method("GET")
     */
    public function showAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $categoryRepository = $em->getRepository('AppBundle:Category');

        //Get category as single object
        $category = $categoryRepository->find($request->get('id'));

        $knpPaginator = $this->get('knp_paginator');

        //Get posts from category
        $pagination = $knpPaginator->paginate($category->getPosts(),
            $request->query->getInt('page', $page), 4
        );

        //Get categories
        $categories = $categoryRepository->findAll();

        if (!$categoryRepository->find($request->get('id'))) {
            throw new NotFoundHttpException('Posts from the category did not found');
        }

        return $this->render('AppBundle:Category:index.html.twig', [
            'posts' => $pagination,
            'categories' => $categories,
            'category' => $category,
        ]);
    }
}

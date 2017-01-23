<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController.
 */
class CategoryController extends Controller
{
    /**
     * @Route("/categories/{id}/{page}", requirements={"page": "\d+"}, name="category_show")
     * @Method("GET")
     *
     * @param Category $category
     * @param int $page
     *
     * @return Response
     */
    public function showAction(Category $category, $page = 1)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAllByCategory($category->getId());

        $pagination = $this->get('knp_paginator')->paginate(
            $posts, $page, 5
        );

        return $this->render('AppBundle:post:index.html.twig', array(
            'title'      => 'Category: '.$category->getName(),
            'pagination' => $pagination
        ));
    }

    public function menuAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        return $this->render('AppBundle:category:menu.html.twig', array(
            'categories' => $categories
        ));
    }
}

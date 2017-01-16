<?php

namespace AppBundle\Controller\Category;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     *@Route("/categories/{id}", requirements={"id" = "\d+"}, defaults={"id" =0}, name="categories")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showSelectedCategoriesAction($id, Request $request)
    {
        $category = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }

        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }

        $posts = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->findBy(array('category' => $id));

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No tags'
            );
        }
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);

        //test using paginator bundle
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => $category,
            'pagination' => $pagination, 'tags' => $tags,
            'userAcl'=>$user,));
    }
}

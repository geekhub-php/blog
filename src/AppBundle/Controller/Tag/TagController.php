<?php

namespace AppBundle\Controller\Tag;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\Request;


class TagController extends Controller
{
    /**
     *@Route("/tags/{id}", requirements={"id" = "\d+"}, defaults={"id" =0}, name="tags")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showSelectedTagAction($id, Request $request)
    {
        $tag = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->find($id);

        if (!$tag) {
            throw $this->createNotFoundException(
                'No tags'
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

        /*$posts = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->findBy($tag);
        dump($posts);

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        */
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);

        //test using paginator bundle
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $tag->getPosts(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('default/index.html.twig', array('data' => $tag->getPosts(),
            'categories' => $count, 'nameCategories' => $tag,
            'pagination' => $pagination, 'tags'=>$tags,));
    }
}

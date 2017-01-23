<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TagController.
 */
class TagController extends Controller
{
    /**
     * @Route("/tags/{id}/{page}", requirements={"page": "\d+"}, name="tag_show")
     * @Method("GET")
     *
     * @param Tag $tag
     * @param int $page
     *
     * @return Response
     */
    public function showAction(Tag $tag, $page = 1)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAllByTag($tag->getId());

        $pagination = $this->get('knp_paginator')->paginate(
            $posts, $page, 5
        );

        return $this->render('AppBundle:post:index.html.twig', array(
            'title'      => 'Tag: '.$tag->getName(),
            'pagination' => $pagination
        ));
    }
}

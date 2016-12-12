<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/", name="postsList")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function listAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        return $this->render('AppBundle:Post:list.html.twig', array(
                'posts' => $posts
            )
        );
    }
}

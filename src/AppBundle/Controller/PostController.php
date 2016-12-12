<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Post;

class PostController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/posts/all", name="all_posts")
     * @Template()
     *
     * @return array;
     */
    public function getAllAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $posts = $repository->findAll();

        return array('posts' => $posts);
    }
}

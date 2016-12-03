<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/posts/all", name="all_posts")
     * @Template()
     */
    public function allAction()
    {
        return array('title' => 1);
    }
}

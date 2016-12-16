<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Model\Page;


/**
 * Class PageController
 * @package AppBundle\Controller
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="blog")
     * @Method({"GET"})
     * @Template()
     */
    public function blogAction()
    {
        $data = new Page();
        $posts = $data->showAll();
        return array('posts' => $posts);
    }

    /**
     * @Route("/posts/{id}", name="single_post")
     * @Method({"GET"})
     * @Template()
     */
    public function singlePostAction($id)
    {
        $data = new Page();
        $post = $data->showById($id);
        return array('post' => $post);
    }
}
<?php

namespace Blog\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

    /**
     * @Route("/", name="home")
     * @Method({"GET"})
     */

    public function indexAction()
    {
        return $this->render('BlogBundle:Page:index.html.twig');
    }

    /**
     * @Route ("/about", name="about")
     * @Method ({"GET"})
     */

    public function aboutAction()
    {
        return $this->render('BlogBundle:Page:about.html.twig');
    }

    /**
     * @Route ("/contact", name="contact")
     * @Method ({"GET"})
     */

    public function contactAction()
    {
        return $this->render('BlogBundle:Page:contact.html.twig');
    }
}

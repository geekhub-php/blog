<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Method({"GET"})
     */

    public function indexAction()
    {
       return $this->render('Page/index.html.twig');

    }

    /**
     * @Route("/about", name="about")
     * @Method({"GET"})
     */
    public function aboutAction()
    {
        return $this->render('Page/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @Method({"GET"})
     */
    public function contactAction()
    {
        return $this->render('Page/contact.html.twig');
    }

}
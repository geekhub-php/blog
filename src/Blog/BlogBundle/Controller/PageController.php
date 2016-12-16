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
        $path = $this->get('kernel')->getRootDir();
        $blogs = json_decode(file_get_contents($path . '/Resources/posts.json'));

        foreach ($blogs as $oneblog) {
            $oneblog = (array) $oneblog;
            $overview = substr($oneblog['blog'], 0, 200);
            $oneblog['overview'] = $overview;
            $oneblog = (object)$oneblog;
            $ready_blogs[]=$oneblog;
        }

        return $this->render('BlogBundle:Page:index.html.twig', array(
            'blogs' => $ready_blogs,
        ));
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

    public function sidebarAction()
    {
        $path = $this->get('kernel')->getRootDir();
        $blogs = json_decode(file_get_contents($path . '/Resources/posts.json'));

        return $this->render('BlogBundle:Page:sidebar.html.twig', array(
            'blogs' => $blogs,
        ));
    }
}

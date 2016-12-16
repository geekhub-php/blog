<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
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
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')->getLatestArticles();

        return $this->render('Page/index.html.twig', array('articles' => $articles));
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

    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository(('AppBundle:Tag'))->getTags();

        $tagWeights = $em->getRepository('AppBundle:Tag')->getTagWeights($tags);

        $categories = $em->getRepository('AppBundle:Category')->findAll();
      //  dump($categories); die();

        return $this->render ('Page/sidebar.html.twig', array (
            'tags' => $tagWeights,
            'categories' => $categories,
        ));
    }
}

<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{

    /**
     * @Route ("/article/{id}", name="showarticle", requirements={"id":"\d+"})
     * @Method({"GET"})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article');
        }

        return $this->render('Article/show.html.twig', array(
            'article' => $article,
        ));
    }
}
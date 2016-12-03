<?php

namespace Blog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

Class BlogController extends Controller
{
    /**
     * @Route ("/{id}", name="showblog", requirements={"id":"\d+"})
     * @Method ({"GET"})
     */

    public function showAction($id)
    {
        $path = $this->get('kernel')->getRootDir();
        $blog = json_decode(file_get_contents($path . '/Resources/posts.json'));
//var_dump($blog[$id]); die("sorry");
        if (!$blog[$id]) {
            throw $this->createNotFoundException('Unable to find Blog post');
        }

        return $this->render('BlogBundle:Blog:show.html.twig', array(
            'blog' => $blog[$id],
        ));
    }

}
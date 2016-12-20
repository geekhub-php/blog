<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Symfony\Component\VarDumper\Cloner\Data;

class PostController extends Controller
{
    /**
     *@Route("/post/{id}", requirements={"id" = "\d+"}, defaults={"id" =0}, name="postPage")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showPostAction($id)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No posts'.$id
            );
        }

        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle:Post');
        $count = $countCategores->getCountCategories($categories);
   return $this->render('default/showPost.html.twig', array('data' => $post,
            'categories' => $count, ));
    }
}

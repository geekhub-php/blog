<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Entity\Comment;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\VarDumper\Cloner\Data;
use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\Request;

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

//$authors=$post->getAuthors();
  //      echo serialize($authors);

//dump($authors);

        //return new Response('Saved new product with id ' . serialize($post));
   return $this->render('default/showPost.html.twig', array('data' =>$post,
            'categories' => $categories));

    }


}
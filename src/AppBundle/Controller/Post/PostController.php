<?php

namespace AppBundle\Controller\Post;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity;
use AppBundle\Entity\Post;
use Symfony\Component\VarDumper\Cloner\Data;

class PostController extends Controller
{
    /**
     * @Route("/post/{id}", requirements={"id" = "\d+"}, defaults={"id" =0}, name="postPage")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showPostAction($id)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }
        $post = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->find($id);
        if (!$post) {
            throw $this->createNotFoundException(
                'No posts' . $id
            );
        }
        $comments = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Comment\\Comment')
            ->findBy(array('post'=>$post->getId()));
        if (!$comments) {
            /*throw $this->createNotFoundException(
                'No comment'
            ); */
            $comments=0;
        }

        $em = $this->getDoctrine()->getManager();
        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);
        //foreach ($post->getAuthors() as $key=>$value) {
          //foreach ($value as $key1 => $value1) {
          //  echo '<br>';
            //echo $value->getId();
            //}
        //echo $post->getAuthors()->getId();
        //}
        //echo serialize($post->getAuthors('gfff'));
        return $this->render('default/showPost.html.twig', array('data' => $post,
            'categories' => $count, 'comments' => $comments,'id'=>$id ));
    }

    /**
     * @Route("/most_commented", name="most_commented")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showMostCommentedAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }

        /*$posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }*/
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);


        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $contComentsPosts =$posts->getPostsMostCommented();

        return $this->render('default/index.html.twig', array('data' => $contComentsPosts,
            'categories' => $count, 'nameCategories' => array('name' => 'most commented posts '), ));
    }
    /**
     *@Route("/top_rated", name="topRated")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showTopRatedAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }
        $em = $this->getDoctrine()->getManager();
        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);

        $posts = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            //PostRepository  function getPostsDescRating()
             ->getPostsTopRated();
          dump($posts);

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }

        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => array('name' => 'top-rated post'), ));
    }

}
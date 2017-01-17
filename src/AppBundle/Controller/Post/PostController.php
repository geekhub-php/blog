<?php

namespace AppBundle\Controller\Post;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Post;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\Request;

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
                'No posts'.$id
            );
        }
        $comments = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Comment\\Comment')
            ->findBy(array('post' => $post->getId()));
        if (!$comments) {
            /*throw $this->createNotFoundException(
                'No comment'
            ); */
            $comments = 0;
        }
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No tags'
            );
        }
        $em = $this->getDoctrine()->getManager();
        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);
        //using acl
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        /*if ($user==="anon.")
            dump($user);
        */
        return $this->render('default/showPost.html.twig', array('data' => $post,
            'categories' => $count, 'comments' => $comments,
            'id' => $id, 'tags' => $tags,
            'userAcl' => $user,  'addOrEdit' => 'add', ));
    }

    /**
     * @Route("/most_commented", name="most_commented")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showMostCommentedAction(Request $request)
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
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No tags'
            );
        }
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $contComentsPosts = $posts->getPostsMostCommented();

        //test paginator bundle
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $contComentsPosts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

        return $this->render('default/index.html.twig', array('data' => $contComentsPosts,
            'categories' => $count, 'nameCategories' => array('name' => 'most commented posts '),
            'pagination' => $pagination, 'tags' => $tags,
            'userAcl' => $user, ));
    }
    /**
     *@Route("/top_rated", name="topRated")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showTopRatedAction(Request $request)
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


        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No tags'
            );
        }
        //test paginator bundle
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => array('name' => 'top-rated post'),
            'pagination' => $pagination, 'tags' => $tags,
            'userAcl' => $user, ));
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostController.
 */
class PostController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/page/{page}", requirements={"id": "\d+"}, name="post_index")
     * @Method("GET")
     *
     * @param int $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page = 1)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAllPosts($page);

        $limit = 5;
        $maxPages = ceil($posts->count() / $limit);
        $thisPage = $page;

        return $this->render('AppBundle:post:index.html.twig', array(
            'posts'     => $posts,
            'maxPages'  => $maxPages,
            'thisPage'  => $thisPage
        ));
    }

    /**
     * @Route("/posts/{id}", requirements={"id": "\d+"}, name="post_show")
     * @Method("GET")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($id);

        $tags = $post->getTags();
        $comments = $post->getComments();

        return $this->render('AppBundle:post:show.html.twig', array(
            'post'      => $post,
            'tags'      => $tags,
            'comments'  => $comments
        ));
    }

    /**
     * @Route("/posts/new", name="post_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        // @TODO: 'New post' functionality.
    }

    /**
     * @Route("/posts/{id}/edit", requirements={"id": "\d+"}, name="post_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        // @TODO: 'Edit post' functionality.
    }

    /**
     * @Route("/posts/{id}/delete", requirements={"id": "\d+"}, name="post_delete")
     * @Method({"GET", "POST"})
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        // @TODO: 'Delete post' functionality.
    }
}

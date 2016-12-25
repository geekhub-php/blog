<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Repository\PostRepository;
use AppBundle\Form\PostType;
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
     * @return Response
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
     * @return Response
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
     * @return Response
     */
    public function newAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:post:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/posts/{id}/edit", requirements={"id": "\d+"}, name="post_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($id);

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $id]);
        }

        return $this->render('AppBundle:post:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/posts/{id}/delete", requirements={"id": "\d+"}, name="post_delete")
     * @Method({"GET", "POST"})
     *
     * @param int $id
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($id);

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}

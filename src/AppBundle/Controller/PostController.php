<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\CommentType;
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
     * @Route("/{page}", requirements={"page": "\d+"}, name="homepage")
     * @Route("/{page}", requirements={"page": "\d+"}, name="post_index")
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
            ->findAllPosts();

        $pagination = $this->get('app.paginator')->paginate($posts, $page);

        return $this->render('AppBundle:post:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/posts/{id}", requirements={"id": "\d+"}, name="post_show")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Post    $post
     *
     * @return Response
     */
    public function showAction(Request $request, Post $post)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find(rand(1, 10));

        $comment = new Comment();
        $comment->setPost($post);
        $comment->setUser($user);

        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $commentData = $commentForm->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($commentData);
            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render('AppBundle:post:show.html.twig', array(
            'post'             => $post,
            'commentForm'      => $commentForm->createView()
        ));
    }

    /**
     * @Route("/admin/{page}", requirements={"page": "\d+"}, name="admin_homepage")
     * @Route("/admin/posts/{page}", requirements={"page": "\d+"}, name="admin_post_index")
     * @Method("GET")
     *
     * @param int $page
     *
     * @return Response
     */
    public function adminIndexAction($page = 1)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAllPosts();

        $pagination = $this->get('app.paginator')->paginate($posts, $page);

        return $this->render('AppBundle:admin/post:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/admin/posts/new", name="admin_post_new")
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
            $postData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($postData);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:admin/default:form.html.twig', array(
            'formTitle' => 'Form: New post',
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/admin/posts/{id}/edit", requirements={"id": "\d+"}, name="admin_post_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Post    $post
     *
     * @return Response
     */
    public function editAction(Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($postData);
            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render('AppBundle:admin/default:form.html.twig', array(
            'formTitle' => 'Form: Edit post',
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/posts/{id}/delete", requirements={"id": "\d+"}, name="admin_post_delete")
     * @Method({"GET", "POST"})
     *
     * @param Post $post
     *
     * @return Response
     */
    public function deleteAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}

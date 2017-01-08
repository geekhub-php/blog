<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * @Route("/{page}", name="homepage", requirements={"page": "\d+"} )
     * @Template()
     * @Method("GET")
     */
    public function indexAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $postRepository = $em->getRepository('AppBundle:Post');
        $categoryRepository = $em->getRepository('AppBundle:Category')->findAll();

        $knpPaginator = $this->get('knp_paginator');

        $pagination = $knpPaginator->paginate($postRepository->findAllOrderByDesc(),
            $request->query->getInt('page', $page), 4
        );

        if (!$postRepository->findAll()) {
            throw new NotFoundHttpException('Empty bro');
        }

        return $this->render('AppBundle:Post:index.html.twig', [
            'posts' => $pagination,
            'categories' => $categoryRepository,
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_show", requirements={"id": "\d+"})
     * @Template()
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:Post')
            ->find($request->get('id'));
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        if (!$post) {
            throw new NotFoundHttpException('Empty bro');
        }

        return $this->render('AppBundle:Post:show.html.twig', [
            'post' => $post,
            'categories' => $categories,
            'comments' => $post->getComments(),
        ]);
    }

    /**
     *
     * @Route("/post/create", name="post_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $post = new Post();

        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        $form = $this->createForm(PostType::class, $post, [
            'em' => $this->getDoctrine()->getManager(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_show', array('id' => $post->getId(),
                'status' => 'created',
            ));
        }

        return $this->render('AppBundle:Post:create.html.twig', array(
                'post' => $post,
                'categories' => $categoryRepository->findAll(),
                'form' => $form->createView(),
            )
        );
    }

    /**
     *
     * @Route("/post/{id}/edit", name="post_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post)
    {
        $editForm = $this->createForm(PostType::class, $post, [
            'em' => $this->getDoctrine()->getManager()
        ]);
        $deleteForm = $this->createDeleteForm($post);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_show', array('id' => $post->getId(),
                'status' => 'edited',
            ));
        }

        return $this->render('AppBundle:Post:edit.html.twig', array(
            'category' => $post,
            'form' => $editForm->createView(),
            'categories' => $categoryRepository->findAll(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/post/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

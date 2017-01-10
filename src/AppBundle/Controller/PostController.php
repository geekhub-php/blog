<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;

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

        return $this->render('AppBundle:Post:index.html.twig', [
            'posts' => $pagination,
            'categories' => $categoryRepository,
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_show", requirements={"id": "\d+"})
     * @Template()
     * @Method({"GET"})
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
        $userRepository = $em->getRepository('AppBundle:User');

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if (!$categoryRepository->findAll() || !$userRepository->findAll()) {
            throw new NotFoundHttpException('Create category and user');
        }

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

    /**
     *
     * @Route("/search/post", name="post_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        $result = $this->get('app.form_manager')
            ->createSearchPostForm($request);

        if ($result['valid'] == true) {
            return $this->render('AppBundle:Post:search.html.twig', array(
                'posts' => $result['posts'],
                'categories' => $categoryRepository->findAll(),
                'form' => $result['form']->createView(),
            ));
        }

        return $this->render('AppBundle:Post:search.html.twig', array(
                'categories' => $categoryRepository->findAll(),
                'form' => $result['form']->createView(),
                'posts' => null,
            )
        );

    }
}

<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use AppBundle\Security\PostVoter;
use Symfony\Component\Form\Form;
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

        $pagination = $knpPaginator->paginate($postRepository->findApprovedOrderByDesc(),
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

        $this->denyAccessUnlessGranted(PostVoter::CREATE, $post);

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        $form = $this->get('app.form_manager')
            ->createNewPostForm($request, $user);
        if ($form instanceof Form)
            return $this->render('AppBundle:Post:create.html.twig', array(
                    'categories' => $categoryRepository->findAll(),
                    'form' => $form->createView(),
                )
            );
        else {
            return $this->redirect($form);
        }
    }

    /**
     *
     * @Route("/post/{id}/edit", name="post_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post)
    {
        $this->denyAccessUnlessGranted(PostVoter::EDIT, $post);

        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->get('app.form_manager')
            ->createEditForm($request, PostType::class, $post, 'post');
        $approveForm = $this->createApproveForm($post);

        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        if ($editForm instanceof Form)
            return $this->render('AppBundle:Post:edit.html.twig', array(
                    'categories' => $categoryRepository->findAll(),
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'approve_form' => $approveForm->createView(),
                )
            );
        else {
            return $this->redirect($editForm);
        }
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
            ->createSearchForm($request, 'AppBundle:Post');

        if ($result['valid'] == true) {
            return $this->render('AppBundle:Post:search.html.twig', array(
                'posts' => $result['data'],
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

    /**
     * @Route("/admin/post/{id}/approve", name="approve_post")
     */
    public function approveAction(Request $request, Post $post)
    {
        $form = $this->createApproveForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setIsApproved(1);
            $em->flush();
        }

        return $this->redirectToRoute('not_approved_posts');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Post $post The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createApproveForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('approve_post', array('id' => $post->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }
}

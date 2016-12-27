<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * Show posts from category
     *
     * @Route("/category/{id}/{page}", name="category_show", requirements={"id": "\d+", "page": "\d+"} )
     * @Method("GET")
     */
    public function showAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $categoryRepository = $em->getRepository('AppBundle:Category');

        //Getting categories for sidebar
        $categories = $categoryRepository->findAll();

        //Getting category as a single object
        if ($categoryRepository->find($request->get('id'))) {
            $category = $categoryRepository->find($request->get('id'));
        }
        else {
            throw new NotFoundHttpException('Category did not found');
        }

        $knpPaginator = $this->get('knp_paginator');

        //Getting posts from category
        $pagination = $knpPaginator->paginate($category->getPosts(),
            $request->query->getInt('page', $page), 4
        );

        return $this->render('AppBundle:Category:index.html.twig', [
            'posts' => $pagination,
            'categories' => $categories,
            'category' => $category,
            'status' => $request->get('status'),
        ]);
    }

    /**
     * Creates a new category
     * @Route("/category/create", name="category_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $category = new Category();

        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        $form = $this->createForm(CategoryType::class, $category, [
            'em' => $this->getDoctrine()->getManager()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_show', array('id' => $category->getId(),
                'status' => 'created',
                ));
        }

        return $this->render('AppBundle:Category:create.html.twig', array(
            'category' => $category,
            'categories' => $categoryRepository->findAll(),
            'form' => $form->createView(),
            )
        );
    }

    /**
     * Editing category
     *
     * @Route("/category/{id}/edit", name="category_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
        $editForm = $this->createForm(CategoryType::class, $category, [
            'em' => $this->getDoctrine()->getManager()
        ]);
        $deleteForm = $this->createDeleteForm($category);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_show', array('id' => $category->getId(),
                'status' => 'edited',
                ));
        }

        return $this->render('AppBundle:Category:edit.html.twig', array(
            'category' => $category,
            'form' => $editForm->createView(),
            'categories' => $categoryRepository->findAll(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a author entity.
     *
     * @Route("/category/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_show');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}

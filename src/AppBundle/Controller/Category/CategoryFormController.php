<?php

namespace AppBundle\Controller\Category;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

class CategoryFormController extends Controller
{
    /**
     *@Route("/admin/show_all_forms_category", name="show_all_forms_category")
     * @Method({"GET", "POST"})
     */
    public function showAllCategoryFormAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();
        $category = new Category\Category();
        $form = $this->createForm(CategoryType::class, $category, [
            'em' => $this->getDoctrine()->getManager(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);

            return $this->redirectToRoute('welcome');
        }
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

        return $this->render('admin/crud_form.html.twig', array(
            'categories' => $categories,
            'category' => $category,
        'form' => $form->createView(),
        'userAcl' => $user,
        ));
    }

    /**
     *@Route("/admin/add_forms_category", name="new_forms_categoru")
     * @Method({"GET", "POST"})
     */
    public function newCatrgoryAction(Request $request)
    {
        $category = new Category\Category();
        $form = $this->createForm(CategoryType::class, $category, [
            'em' => $this->getDoctrine()->getManager(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);

            return $this->redirectToRoute('category_form_show',
                array('id' => $category->getId()));
        }

        return $this->render('admin/new_form.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }
/**
 * @Route("/admin/category_edit/{id}", requirements={"id" = "\d+"}, defaults={"id" =1}, name="category_edit")
 * @Method({"GET", "POST"})
 */
public function editAction(Request $request, Category\Category $category, $id)
{
    $deleteForm = $this->createDeleteForm($category);
    $editForm = $this->createForm(CategoryType::class, $category, [
        'em' => $this->getDoctrine()->getManager(),
    ]);
    $editForm->handleRequest($request);
    if ($editForm->isValid()) {
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('show_all_forms_category', array('id' => $category->getId()));
    }
    $tokenStorage = $this->get('security.token_storage');
    $user = $tokenStorage->getToken()->getUser();

    return $this->render('admin/edit_form.html.twig', array(
        'category' => $category,
           // 'id' =>$id,
            'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        'userAcl' => $user,
    ));
}
    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("Delete")
     */
    public function deleteAction(Request $request, Category\Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush($category);
        }

        return $this->redirectToRoute('show_all_forms_category');
    }

    /**
     * Creates a form to delete a author entity.
     *
     * @param Category\Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category\Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

<?php

namespace AppBundle\Controller\Category;

use AppBundle\Form\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Symfony\Component\VarDumper\Cloner\Data;
use AppBundle\Form\CategoryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CategoryFormController extends Controller
{
    /**
     *@Route("/show_all_forms_category", name="show_all_forms_category")
     * @Method({"GET", "POST"})
     */
    public function showAllCategoryFormAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();
        $category = new Category\Category();
        $form = $this->createForm(CategoryType::class, $category    , [
            'em' => $this->getDoctrine()->getManager()
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);
            return $this->redirectToRoute("welcome");
        }

        return $this->render('default/crud_form.html.twig', array(
            'categories' => $categories,
            'category' => $category,
        'form' => $form->createView(),
        ));
    }

    /**
     *@Route("/add_forms_category", name="new_forms_categoru")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {





        $category = new Category\Category();
        $form = $this->createForm(CategoryType::class, $category    , [
            'em' => $this->getDoctrine()->getManager()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);
            return $this->redirectToRoute('category_form_show',
                array('id' => $category->getId()));
        }

        return $this->render('default/new_form.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));

    }
    /**
* @Route("/category_edit/{id}", requirements={"id" = "\d+"}, defaults={"id" =1}, name="category_edit")
* @Method({"GET", "POST"})
*/
public function editAction(Request $request, Category\Category $category, $id)
{

    $deleteForm = $this->createDeleteForm($category);
    $editForm = $this->createForm(CategoryType::class, $category    , [
        'em' => $this->getDoctrine()->getManager()
    ]);
    $editForm->handleRequest($request);
   if ($editForm->isValid()) {
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('show_all_forms_category', array('id' => $category->getId()));
    }

    return $this->render('default/edit_form.html.twig', array(
        'category' => $category,
           // 'id' =>$id,
            'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
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

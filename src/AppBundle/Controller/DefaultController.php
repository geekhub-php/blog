<?php

namespace AppBundle\Controller;

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

class DefaultController extends Controller
{
    /**
     * @Route("/", name="welcome")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }

        $posts = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);





        //echo gettype($categories);

        //echo serialize($count);

        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => array('name' => 'last posts'), ));
    }



    /**
     *@Route("/contacts", name="contacts")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showContactsAction()
    {
        return $this->render('default/contacts.html.twig');
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


        //$form->handleRequest($request);

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
       // return $this->render('default/new_form.html.twig');
    }
    /**
     * Finds and displays a author entity.
     *
     * @Route("category_form_show/{id}", name="category_form_show")
     * @Method("GET")
     */
    public function showCategoryFormAction(Category\Category $category)
    {
       // $deleteForm = $this->createDeleteForm($category);

        return $this->render('default/show_form.html.twig', array(
            'category' => $category,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

}

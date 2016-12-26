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
use AppBundle\Form\PostType;
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
     *@Route("/show_all_forms_post", name="show_all_forms_post")
     * @Method({"GET", "POST"})
     */
    public function showAllPostFormAction(Request $request)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->findAll();
        $post = new Post\Post();
        $form = $this->createForm(PostType::class, $post, [
            'em' => $this->getDoctrine()->getManager()
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush($post);
            return $this->redirectToRoute("welcome");
        }

        return $this->render('default/crud_form.html.twig', array(
            'posts' => $posts,
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

}

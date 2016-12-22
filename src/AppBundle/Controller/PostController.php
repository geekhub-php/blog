<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/", name="postsList")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function listAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->getPostsList();

        return $this->render('AppBundle:Post:list.html.twig', array(
                'posts' => $posts
            )
        );
    }

    /**
     * @Route("/posts/view/{id}", name="postsView")
     * @Method({"GET"})
     */
    public function viewAction($id)
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')
            ->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        return $this->render('AppBundle:Post:view.html.twig', array(
                'post' => $post
            )
        );
    }

    /**
     * @Route("/posts/create", name="postsCreate")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $post = new Post();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('description', TextareaType::class, array('label' => 'Short Description'))
            ->add('visibility', ChoiceType::class, array(
                'choices' => array(
                    'Visible' => 1,
                    'Hidden' => 0,
                )
            ))
            ->add('createAt', DateTimeType::class, array(
                'format' => 'HTML5_FORMAT'
            ))
            ->add('author', EntityType::class, array(
                'class' => 'AppBundle:Author',
                'choice_label' => 'firstName',
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('postsList');
        }

        return $this->render('AppBundle:Post:create.html.twig', array(
            'form' => $form->createView()
        ));

    }
}

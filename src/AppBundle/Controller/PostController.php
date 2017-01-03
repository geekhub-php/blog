<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Category;
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
     *
     * @param Request $request
     * @param int $id
     * @return string
     *
     * @Route("/posts/view/{id}", name="postsView")
     * @Method({"GET", "POST"})
     */
    public function viewAction(Request $request, $id)
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')
            ->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')
            ->getCommentsByPost($post->getId());


        // Create new Comment Form

        $comment = new Comment();
        $form = $this->createForm('AppBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->addComment($comment);
            $em->persist($comment);
            $em->flush($comment);
//            $post->getComments()->add($comment);

            return $this->redirectToRoute('postsView', array('id' => $post->getId()));
        }

        return $this->render('AppBundle:Post:view.html.twig', array(
                'post' => $post,
                'comments' => $comments,
                'comment' => $comment,
                'form' => $form->createView(),
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

    /**
     * Edit post.
     *
     * @Route("/posts/edit/{id}", name="postsEdit",
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($id);

        $form = $this->createForm('AppBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('postsView', array('id' => $post->getId()));
        }

        return $this->render('AppBundle:Post:edit.html.twig', array(
            'post' => $post,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/posts/{postId}/comment/{commentId}", name="editComment")
     * @Method({"GET", "POST"})
     */
    public function editComment(Request $request, $postId, $commentId)
    {
        $comment = $this->getDoctrine()
            ->getRepository('AppBundle:Comment')
            ->find($commentId);
        $form = $this->createForm('AppBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('postsView', array('id' => $postId));
        }

        return $this->render('AppBundle:Comment:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     *
     * @Route("/posts/{postId}/comment/remove/{commentId}", name="removeComment")
     * @Method({"GET", "POST"})
     *
     */
    public function removeCommentAction($postId, $commentId)
    {
//        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->find($postId);
        $comment = $this->getDoctrine()->getRepository('AppBundle:Comment')->find($commentId);
//        $post->removeComment($comment);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($post);
//        $em->flush();

        $form = $this->createForm('AppBundle\Form\CommentRemoveType', $comment);

        return $this->render('AppBundle:Comment:remove.html.twig', array(
            'form' => $form->createView()
        ));
//        return $this->redirectToRoute('postsView', array('id' => $post->getId()));
    }
}

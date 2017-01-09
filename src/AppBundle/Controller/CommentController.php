<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CommentController.
 */
class CommentController extends Controller
{
    /**
     * @Route("/posts/{postId}/comments/{id}/edit",
     *     requirements={"postId": "\d+", "id": "\d+"},
     *     name="comment_edit"
     * )
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param int     $postId
     * @param int     $id
     *
     * @return Response
     */
    public function editAction(Request $request, $postId, $id)
    {
        $comment = $this->getDoctrine()
            ->getRepository('AppBundle:Comment')
            ->find($id);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $postId]);
        }

        return $this->render('AppBundle:base:form.html.twig', array(
            'formTitle' => 'Form: Edit comment',
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/posts/{postId}/comments/{id}/delete",
     *     requirements={"postId": "\d+", "id": "\d+"},
     *     name="comment_delete"
     * )
     * @Method({"GET", "POST"})
     *
     * @param int $postId
     * @param int $id
     *
     * @return Response
     */
    public function deleteAction($postId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->find($id);

        $comment->setContent('Comment deleted.');

        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('post_show', ['id' => $postId]);
    }
}

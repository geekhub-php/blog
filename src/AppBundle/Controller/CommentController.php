<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentController extends Controller
{
    /**
     *
     * @Route("/post/{id}/comment/create", name="comment_create", requirements={"id": "\d+"})
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment, [
            'em' => $this->getDoctrine()->getManager(),
            'action' => $this->generateUrl('comment_create', [
                'id' => $request->get('id')
            ]),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('AppBundle:Post')
                ->find($request->get('id'));

            $comment = $form->getData();
            $comment->setPost($post);
            $post->addComment($comment);

            $em->persist($comment);
            $em->persist($post);

            $em->flush();

            return $this->redirectToRoute('post_show', array('id' => $post->getId(),
            ));
        }

        return $this->render('AppBundle:Comment:create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/post/{postId}/comment/{id}/edit", name="comment_edit", requirements={"postId": "\d+", "id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comment $comment)
    {
        $editForm = $this->createForm(CommentType::class, $comment, [
            'em' => $this->getDoctrine()->getManager()
        ]);
        $deleteForm = $this->createDeleteForm($comment);

        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_show', array('id' => $request->get('postId'),
            ));
        }

        return $this->render('AppBundle:Comment:edit.html.twig', array(
            'comment' => $comment,
            'form' => $editForm->createView(),
            'categories' => $categoryRepository->findAll(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/comment/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comment $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
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
    private function createDeleteForm(Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

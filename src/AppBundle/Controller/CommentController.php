<?php

namespace AppBundle\Controller;



use AppBundle\Entity\Article;
use AppBundle\Entity\Author;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @param Article|null $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/article/{id}/newComment", name="new_comment")
     */
    public function newAction(Request $request, Article $article)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $comment->setArticle($article);

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('show_article', ['id' =>$article->getId()]);
        }
        return $this->render('AppBundle:Forms:newComment.html.twig', [
            'commentType' => $form->createView(),
            'id' => $article->getId(),
        ]);
    }

    /**
     * @param Comment $comment
     * @return Response
     *
     * @Route("comment/{id}/delete", name="delete_comment", requirements={"\d+"})
     */
    public  function deleteAction(Comment $comment){

        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('show_article');
    }

}
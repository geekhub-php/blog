<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 26.12.16
 * Time: 13:02
 */

namespace AppBundle\Controller\Comment;
use AppBundle\Form\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;
use Symfony\Component\VarDumper\Cloner\Data;
use AppBundle\Form\CategoryType;
use AppBundle\Form\PostType;
use AppBundle\Form\CommentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CommentFormController extends Controller
{


    /**
     *@Route("/add_comment", name="add_comment")
     * @Method({"GET", "POST"})
     */
    public function addCommnetTestAction(Request $request)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->find('3');
        $comment = new Comment\Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'em' => $this->getDoctrine()->getManager()
        ]);

        $form->handleRequest($request);
       // $form->get('post')->setData($post->getId());


        if ($form->isSubmitted() && $form->isValid()) {
            //$form->get('post')->setData($post->getId());
            $em = $this->getDoctrine()->getManager();
            $comment->setPost($post);
            //$em->setPost($post->getId());
            $em->persist($comment);
            $em->flush($comment);


            return $this->redirectToRoute("welcome");
        }

        return $this->render('default/crud_form_comment_test.html.twig', array(
                        'comment' => $comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("Delete")
     */
    public function deleteAction(Request $request, Comment\Comment $comment)
    {

        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush($comment);
        }

        return $this->redirectToRoute('add_comment');

    }
    private function createDeleteForm(Comment\Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }






}
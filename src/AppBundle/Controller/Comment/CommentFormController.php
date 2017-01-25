<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 26.12.16
 * Time: 13:02.
 */

namespace AppBundle\Controller\Comment;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;
use Symfony\Component\VarDumper\Cloner\Data;
use AppBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class CommentFormController extends Controller
{
    /**
     *@Route("/post/{id}/add_comment", name="add_comment")
     * @Method({"GET", "POST"})
     */
    public function addCommnetTestAction(Request $request, $id)
    {




        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }
        $post = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->find($id);
        if (!$post) {
            throw $this->createNotFoundException(
                'No posts'.$id
            );
        }
        $comments = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Comment\\Comment')
            ->findBy(array('post' => $post->getId()));
        if (!$comments) {
            /*throw $this->createNotFoundException(
                'No comment'
            ); */
            $comments = 0;
        }
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No tags'
            );
        }
        $countLikes=count($post->getLikes());
        $em = $this->getDoctrine()->getManager();
        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);
        $comment = new Comment\Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'em' => $this->getDoctrine()->getManager(),
        ]);

        $form->handleRequest($request);
       // $form->get('post')->setData($post->getId());

        if ($form->isSubmitted() && $form->isValid()) {
            //$form->get('post')->setData($post->getId());
            $em = $this->getDoctrine()->getManager();
            $comment->setPost($post);
            $comment->setDate(new \DateTime("now"));
            $comment->setEnabled('true');
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush($comment);

          //using acl securety token_storege
            $tokenStorage = $this->get('security.token_storage');

            $user = $tokenStorage->getToken()->getUser();

            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($comment);
            $acl = $aclProvider->createAcl($objectIdentity);
            $securityIdentity = UserSecurityIdentity::fromAccount($user);
            // grant owner access
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            return $this->redirectToRoute('welcome');
        }
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

        return $this->render('default/showPost.html.twig', array('data' => $post,
            'categories' => $count, 'comments' => $comments, 'comment' => $comment,
            'form' => $form->createView(), 'id' => $id,
            'tags' => $tags, 'userAcl' =>$user, 'addOrEdit' => 'add',
            'countLikes'=>$countLikes));

        /*return $this->render('default/showPost.html.twig', array(
                        'comment' => $comment,
            'form' => $form->createView(),
        ));
        */
    }

    /**
     * @Route("/comment_edit/{id}", requirements={"id" = "\d+"}, defaults={"id" =1}, name="comment_edit")
     * @Method({"GET", "POST"})
     */
    public function editCommentAction(Request $request, Comment\Comment $commentParam, $id)
    {

        $comment =$this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Comment\\Comment')
            ->find($id);


        $this->denyAccessUnlessGranted('edit', $comment);

        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }
        /*$post = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->find($id);
        if (!$post) {
            throw $this->createNotFoundException(
                'No posts'.$id
            );
        }
        */

        /*

         $comments = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Comment\\Comment')
            ->findBy(array('post' => $post->getId()));
        if (!$comments) {
            throw $this->createNotFoundException(
                'No comment'
            );
            $comments = 0;
        }
        */
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No tags'
            );
        }
        $em = $this->getDoctrine()->getManager();
        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);

        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteFormComment($comment);
        $editForm = $this->createForm(CommentType::class, $comment, [
            'em' => $this->getDoctrine()->getManager(),
        ]);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $comment->setDate(new \DateTime("now"));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('welcome');
        }

        $tokenStorage = $this->get('security.token_storage');

        $user = $tokenStorage->getToken()->getUser();
        return $this->render('default/showPost.html.twig', array('data' => 'comment edit',
            'categories' => $count, /*'comments' => $comments, */ 'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form_comment' => $deleteForm->createView(),
            'id' => $id, 'tags' => $tags, 'addOrEdit' => 'edit', 'userAcl' =>$user));

        /*return $this->render('default/edit_form_post.html.twig', array(
            'post' => $post,
            // 'id' =>$id,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
        */
    }

    /**
     *@Route("/admin/show_all_forms_comment", name="show_all_forms_comment")
     * @Method({"GET", "POST"})
     */
    public function showAllCommentFormAction(Request $request)
    {
        $comments = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Comment\\Comment')
            ->findAll();
        /*$comment = new Comment\Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'em' => $this->getDoctrine()->getManager(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush($comment);

            return $this->redirectToRoute('show_all_forms_comment');
        }
*/
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

        return $this->render('admin/crud_form_comment.html.twig', array(
            'comments' => $comments,
            'userAcl' => $user,
        ));
    }
    /**
     * @Route("/admin/comment_edit/{id}", requirements={"id" = "\d+"}, defaults={"id" =1}, name="comment_edit_admin")
     * @Method({"GET", "POST"})
     */
    public function editCommentAdminPaanelAction(Request $request, Comment\Comment $comment, $id)
    {
        $deleteForm = $this->createDeleteFormComment($comment);
        $editForm = $this->createForm(CommentType::class, $comment, [
            'em' => $this->getDoctrine()->getManager(),
        ]);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $comment->setDate(new \DateTime("now"));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_all_forms_comment', array('id' => $comment->getId()));
        }

        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        $author = $comment->getUser();

        $inspection = $this->get('service_inspection_id_route');
        $inspection->setValue($author, 'null', $user);
        $resultInspection = $inspection->getValue();
        //dump($resultInspection);
        return $this->render('admin/edit_form_comment.html.twig', array(
            'comment' => $comment,
            // 'id' =>$id,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'userAcl' => $user,
        ));
    }

    /**
     * Deletes a comment entity.
     *
     * @Route("/comment_delete{id}", name="comment_delete")
     * @Method("Delete")
     */
    public function deleteCommentAction(Request $request, Comment\Comment $comment)
    {
        $form = $this->createDeleteFormComment($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush($comment);
        }

        return $this->redirectToRoute('welcome');
    }
    private function createDeleteFormComment(Comment\Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

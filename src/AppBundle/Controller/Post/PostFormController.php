<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 26.12.16
 * Time: 13:02.
 */

namespace AppBundle\Controller\Post;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

class PostFormController extends Controller
{
    /**
     *@Route("/admin/show_all_forms_post", name="show_all_forms_post")
     * @Method({"GET", "POST"})
     */
    public function showAllPostFormAction(Request $request)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->findAll();
        $post = new Post\Post();
        $form = $this->createForm(PostType::class, $post, [
            'em' => $this->getDoctrine()->getManager(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush($post);

            return $this->redirectToRoute('welcome');
        }

        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        return $this->render('admin/crud_form_post.html.twig', array(
            'posts' => $posts,
            'post' => $post,
            'form' => $form->createView(),
            'userAcl'=>$user,
        ));
    }
    /**
     * @Route("/admin/post_edit/{id}", requirements={"id" = "\d+"}, defaults={"id" =1}, name="post_edit")
     * @Method({"GET", "POST"})
     */
    public function editPostAction(Request $request, Post\Post $post, $id)
    {


        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm(PostType::class, $post, [
            'em' => $this->getDoctrine()->getManager(),
        ]);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_all_forms_post', array('id' => $post->getId()));
        }

        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

        //$authors=array('author' => $post->getAuthors());
        $authors=$post->getAuthors();
        $inspection = $this->get('service_inspection_id_route');
       $inspection->setValue("null", $authors, $user);
        $resultInspection=$inspection->getValue();
        //foreach ($authors as $key => $value){
        //dump($resultInspection);
        //}
        return $this->render('admin/edit_form_post.html.twig', array(
            'post' => $post,
            // 'id' =>$id,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'userAcl'=>$user,
        ));
    }
    /**
     * Deletes a post entity.
     *
     * @Route("/admin/post_delete/{id}", name="post_delete")
     * @Method("Delete")
     */
    public function deletePostAction(Request $request, Post\Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush($post);
        }

        return $this->redirectToRoute('show_all_forms_post');
    }

    private function createDeleteForm(Post\Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}

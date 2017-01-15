<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 26.12.16
 * Time: 13:02.
 */

namespace AppBundle\Controller\Tag;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

class TagFormController extends Controller
{
    /**
     *@Route("/admin/show_all_forms_tag", name="show_all_forms_tag")
     * @Method({"GET", "POST"})
     */
    public function showAllTagFormAction(Request $request)
    {
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();
        $tag = new Tag\Tag();
        $form = $this->createForm(TagType::class, $tag, [
            'em' => $this->getDoctrine()->getManager(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush($tag);

            return $this->redirectToRoute('show_all_forms_tag');
        }

        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        return $this->render('admin/crud_form_tag.html.twig', array(
            'tags' => $tags,
            'tag' => $tag,
            'form' => $form->createView(),
            'userAcl'=>$user,
        ));
    }
    /**
     * @Route("/admin/tag_edit/{id}", requirements={"id" = "\d+"}, defaults={"id" =1}, name="tag_edit")
     * @Method({"GET", "POST"})
     */
    public function editTagAction(Request $request, Tag\Tag $tag, $id)
    {
        $deleteForm = $this->createDeleteFormTag($tag);
        $editForm = $this->createForm(TagType::class, $tag, [
            'em' => $this->getDoctrine()->getManager(),
        ]);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_all_forms_tag', array('id' => $tag->getId()));
        }

        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        return $this->render('admin/edit_form_tag.html.twig', array(
            'tag' => $tag,
            // 'id' =>$id,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'userAcl'=>$user,
        ));
    }
    /**
     * Deletes a post entity.
     *
     * @Route("/admin/tag_delete/{id}", name="tag_delete")
     * @Method("Delete")
     */
    public function deleteTagAction(Request $request, Tag\Tag $tag)
    {
        $form = $this->createDeleteFormTag($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush($tag);
        }

        return $this->redirectToRoute('show_all_forms_tag');
    }

    private function createDeleteFormTag(Tag\Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_delete', array('id' => $tag->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}

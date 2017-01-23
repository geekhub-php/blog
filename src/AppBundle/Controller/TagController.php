<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TagController.
 */
class TagController extends Controller
{
    /**
     * @Route("/tags/{id}/{page}", requirements={"page": "\d+"}, name="tag_show")
     * @Method("GET")
     *
     * @param Tag $tag
     * @param int $page
     *
     * @return Response
     */
    public function showAction(Tag $tag, $page = 1)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAllByTag($tag->getId());

        $pagination = $this->get('knp_paginator')->paginate(
            $posts, $page, 5
        );

        return $this->render('AppBundle:post:index.html.twig', array(
            'title'      => 'Tag: '.$tag->getName(),
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/admin/tags/{page}", requirements={"page": "\d+"}, name="admin_tag_index")
     * @Method("GET")
     *
     * @param int $page
     *
     * @return Response
     */
    public function adminIndexAction($page = 1)
    {
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle:Tag')
            ->findBy(
                array(),
                array('id' => 'desc')
            );

        $pagination = $this->get('knp_paginator')->paginate(
            $tags, $page, 5
        );

        return $this->render('AppBundle:admin/tag:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * @Route("/admin/tags/new", name="admin_tag_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        $tag = new Tag();

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($postData);
            $em->flush();

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('AppBundle:admin/default:form.html.twig', array(
            'formTitle' => 'Add new tag',
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/admin/tags/{id}/edit", requirements={"id": "\d+"}, name="admin_tag_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Tag     $tag
     *
     * @return Response
     */
    public function editAction(Request $request, Tag $tag)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($postData);
            $em->flush();

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('AppBundle:admin/default:form.html.twig', array(
            'formTitle' => 'Edit tag',
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/tags/{id}/delete", requirements={"id": "\d+"}, name="admin_tag_delete")
     * @Method({"GET", "POST"})
     *
     * @param Tag $tag
     *
     * @return Response
     */
    public function deleteAction(Tag $tag)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();

        $em->remove($tag);
        $em->flush();

        return $this->redirectToRoute('admin_tag_index');
    }
}

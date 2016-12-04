<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\PostEntity;
use BlogBundle\Entity\CategoryEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        $entity = new PostEntity();
        $posts = $entity->getPosts();
        return array(
            'title' => 'My am4zing bl0g',
            'posts' => $posts,
            'categories' => CategoryEntity::getCategories(),
            'page' => 'home',
        );
    }

    /**
     * Matches /post/*
     *
     * @Template()
     * @Route("/post/{id}", name="post_show", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $object = new PostEntity();
        $post = $object->getPost($request->get('id'));
        if (!$post) {
            throw $this->createNotFoundException('Post #' . $request->get('id') . ' not found');
        }
        return array(
            'post' => $post,
            'categories' => CategoryEntity::getCategories(),
            'status' => $request->get('status'),
        );
    }

    /**
     * Matches /post/*
     * @Template()
     * @Route("/post/create", name="post_create", requirements={"id": "\d+"})
     * @Method({"GET", "PUT"})
     */
    public function createAction(Request $request)
    {
        if ($request->get('title') && $request->get('text')) {
            return new Response($this->redirectToRoute('post_show', array(
                'status' => 'created',
                'id' => rand(1, 5),
            ), 301));
        }
        return array(
            'categories' => CategoryEntity::getCategories(),
            'status' => 'create',
        );
    }

    /**
     * Matches /post/*
     *
     * @Route("/post/{id}/edit", name="post_edit", requirements={"id": "\d+"})
     * @Method({"GET", "PATCH"})
     */
    public function editAction(Request $request)
    {
        if ($request->get('title') && $request->get('text')) {
            return new Response($this->redirectToRoute('post_show', array(
                'status' => 'edited',
                'id' => $request->get('id'),
        ), 301));
        }
        return new Response($this->render('@Blog/Post/create.html.twig', array(
            'categories' => CategoryEntity::getCategories(),
            'status' => 'edit',
            'id' => rand(1, 5),
        )));
    }

    /**
     * Matches /post/*
     *
     * @Route("/post/{id}/delete", name="post_delete", requirements={"id": "\d+"})
     * @Method({"GET","DELETE"})
     * @Template()
     */
    public function removeAction(Request $request)
    {
        if ($request->get('id') && $request->get('idpost')) {
            return array(
                'status' => 'deleted',
                'categories' => CategoryEntity::getCategories()
            );
        }
        return array(
            'status' => 'delete',
            'categories' => CategoryEntity::getCategories(),
            'idpost' => $request->get('id'),
        );
    }
}

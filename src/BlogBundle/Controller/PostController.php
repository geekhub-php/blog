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
        $entityCategories = new CategoryEntity();
        $categories = $entityCategories->getCategories();
        return array(
            'title' => 'My am4zing bl0g',
            'posts' => $posts,
            'categories' => $categories,
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
        $entityCategories = new CategoryEntity();
        $categories = $entityCategories->getCategories();
        if(!$post) {
            throw $this->createNotFoundException('Post #' . $request->get('id') . ' not found');
        }
        return array(
            'post' => $post,
            'categories' => $categories,
        );
    }

    /**
     * Matches /post/*
     * @Template()
     * @Route("/post/create", name="post_create")
     * @Method({"GET", "POST"})
     */
    public function createAction (Request $request)
    {
        $entityCategories = new CategoryEntity();
        $categories = $entityCategories->getCategories();
        if ($request->get('title') && $request->get('text')) {
            return $this->render('@Blog/Post/success.html.twig',
                array('categories' => $categories,
                    'status' => 'create'));
        }
        return array(
            'categories' => $categories,
            'status' => 'create',
        );
    }

    /**
     * Matches /post/*
     *
     * @Route("/post/{id}/edit", name="post_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction (Request $request)
    {
        $entityCategories = new CategoryEntity();
        $categories = $entityCategories->getCategories();
        $id = $request->get('id');
        if ($request->get('title') && $request->get('text')) {
            return new Response($this->render('@Blog/Post/success.html.twig', array(
                'categories' => $categories,
                'status' => 'edited',
        )));
        }
        return new Response($this->render('@Blog/Post/create.html.twig', array(
            'categories' => $categories,
            'status' => 'edit',
            'id' => $randomId,
        )));
    }

    /**
     * Matches /post/*
     *
     * @Route("/post/{id}/remove", name="post_delete", requirements={"id": "\d+"})
     */
    public function removeAction (Request $request)
    {
        if ($request->getMethod() == 'DELETE') {
            return new JsonResponse(array(
                'msg' => 'Deleted post #' . $request->get('id'),
            ));
        }
        return new JsonResponse();
    }
}

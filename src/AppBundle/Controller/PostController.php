<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Repository\DataRepository;

class PostController extends Controller
{
    /**
     * Display all posts
     *
     * @return string Display page with posts list
     *
     * @Route("/", name="postsList")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $posts = DataRepository::readData();

        return $this->render('AppBundle:Post:list.html.twig', array(
            'posts' => $posts
        ));
    }

    /**
     * Display single post by ID
     *
     * @param int $id Post ID
     * @return string|Exception Page code
     *
     * @Route("/post/view/{id}", name="postView",
     *     requirements = {
     *         "id": "\d+"
     *     }
     * )
     * @Method({"GET"})
     */
    public function viewAction($id)
    {
        $posts = DataRepository::readData();

        foreach ($posts as $post) {
            if ($post->id == $id) {
                return $this->render('AppBundle:Post:view.html.twig', array(
                    'post' => $post
                ));
            }
        }
        throw $this->createNotFoundException('The post does not exist!');
    }

    /**
     * Display form for new post creation
     *
     * @return string Generate page for new post creation
     *
     * @Route("/post/create", name="createPost")
     * @Method({"GET"})
     */
    public function createAction()
    {
        return $this->render('AppBundle:Post:create.html.twig', array(
            // ...
        ));
    }

    /**
     * Store data of new post
     *
     * @param Request $request Request object
     * @return string Page code
     *
     * @Route("/post/store", name="storePost")
     * @Method({"POST"})
     */
    public function storeAction(Request $request)
    {
        $id = $request->request->get('id');
        $title = $request->request->get('title');
        $content = $request->request->get('content');

        $posts = DataRepository::readData();
        $posts[] = [
            'id'      => $id,
            'title'   => $title,
            'content' => $content
        ];

        DataRepository::writeData($posts);
        return $this->redirectToRoute('createPost');
    }

    /**
     * Display form for existing post edition
     *
     * @param int $id Post identifier
     * @return string Page code
     * @throws \Exception Not found exception
     *
     * @Route("/post/edit/{id}", name="postEdit",
     *     defaults={
     *          "id": "1"
     *     },
     *     requirements={
     *          "id": "\d+"
     *     }
     * )
     * @Method({"GET"})
     */
    public function editAction($id)
    {
        $posts = DataRepository::readData();

        foreach ($posts as $post) {
            if ($post->id == $id) {
                return $this->render('AppBundle:Post:edit.html.twig', array(
                    'post' => $post
                ));
            }
        }
        throw $this->createNotFoundException('The post does not exist!');
    }

    /**
     * Update data of existing post
     *
     * @param Request $request Request object
     * @return string Redirect to route
     *
     * @Route("/post/update", name="postUpdate")
     * @Method({"POST"})
     */
    public function updateAction(Request $request)
    {
        $id = $request->request->get('id');
        $title = $request->request->get('title');
        $content = $request->request->get('content');

        $posts = DataRepository::readData();

        foreach ($posts as $post) {
            if ($post->id == $id) {
                $post->title = $title;
                $post->content = $content;
            }
        }

        DataRepository::writeData($posts);
        return $this->redirectToRoute('postEdit');
    }

    /**
     * Display form for post deleting
     *
     * @Route("/post/delete/{id}", name="postDelete", requirements={
     *      "id": "\d+"
     * })
     * @Method({"GET"})
     */
    public function deleteAction($id)
    {
        if ($id) {
            return $this->render('AppBundle:Post:delete.html.twig', array(
                'id' => $id
            ));
        } else {
            throw $this->createNotFoundException('The post does not exist!');
        }
    }

    /**
     * Remove post by id
     *
     * @param Request $request Request object
     * @return string Redirect to route
     *
     * @Route("/post/remove", name="postRemove")
     * @Method({"POST"})
     */
    public function removeAction(Request $request)
    {
        $id = $request->request->get('id');
        if (!empty($id)) {
            $posts = DataRepository::readData();

            foreach ($posts as $key => $post) {
                if ($post->id == $id) {
                    unset($posts[$key]);
                }
            }

            DataRepository::writeData($posts);
            return $this->redirectToRoute('postList');
        }
        throw $this->createNotFoundException('Post does not found!');
    }
}

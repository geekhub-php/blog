<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostEntity;
use AppBundle\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PostController.
 */
class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * @Route("/", name="post_index")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->repository = new PostRepository();

        $postsData = $this->repository->findAll();

        return $this->render('AppBundle:post:index.html.twig', array(
            'posts' => $postsData
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $this->repository = new PostRepository();

        $postsData = $this->repository->findAll();

        return $this->render('AppBundle:post:list.html.twig', array(
            'posts' => $postsData
        ));
    }

    /**
     * @Route("/post/new", name="post_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $this->repository = new PostRepository();

        $title = $request->request->get('title');
        $content = $request->request->get('content');

        if (!empty($title)) {
            $post = new PostEntity();
            $post->setTitle($title);
            $post->setContent($content);

            $this->repository->insert($post);

            return $this->redirectToRoute('post_index');
        }

        return $this->render('AppBundle:post:new.html.twig', array(
            'title'     => '',
            'content'   => ''
        ));
    }

    /**
     * @Route("/post/{id}", requirements={"id": "\d+"}, name="post_show")
     * @Method("GET")
     *
     * @param int $id
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $this->repository = new PostRepository();

        $postData = $this->repository->find($id);

        if (!empty($postData)) {
            return $this->render('AppBundle:post:show.html.twig', array(
                'post' => $postData
            ));
        } else {
            return new JsonResponse(['Error404:' => 'Not Found'], 404);
        }
    }

    /**
     * @Route("/post/{id}/edit", requirements={"id": "\d+"}, name="post_edit")
     * @Method({"POST", "GET", "PUT", "PATCH"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $this->repository = new PostRepository();

        $title = $request->request->get('title');
        $content = $request->request->get('content');

        if (!empty($title)) {
            $post = new PostEntity();
            $post->setId($id);
            $post->setTitle($title);
            $post->setContent($content);

            $this->repository->update($post);

            return $this->redirectToRoute('post_index');
        }

        $postData = $this->repository->find($id);

        return $this->render('AppBundle:post:edit.html.twig', array(
            'title'     => $postData['title'],
            'content'   => $postData['content']
        ));
    }

    /**
     * @Route("/post/{id}/delete", requirements={"id": "\d+"}, name="post_delete")
     * @Method({"POST", "GET", "DELETE"})
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $this->repository = new PostRepository();

        $this->repository->remove($id);

        return $this->redirectToRoute('post_index');
    }
}

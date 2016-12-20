<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * @Route("/{page}", name="homepage", requirements={"page": "\d+"} )
     * @Template()
     * @Method("GET")
     */
    public function indexAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $postRepository = $em->getRepository('AppBundle:Post');
        $categoryRepository = $em->getRepository('AppBundle:Category')->findAll();

        $knpPaginator = $this->get('knp_paginator');

        $pagination = $knpPaginator->paginate($postRepository->findAllOrderByDesc(),
            $request->query->getInt('page', $page), 4
        );

        if (!$postRepository->findAll()) {
            throw new NotFoundHttpException('Empty bro');
        }

        return $this->render('AppBundle:Post:index.html.twig', [
            'posts' => $pagination,
            'categories' => $categoryRepository,
        ]);
    }

    /**
     * @Route("/post/{id}", name="post_show", requirements={"id": "\d+"} )
     * @Template()
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:Post')
            ->find($request->get('id'));
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('AppBundle:Post:show.html.twig', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }
}

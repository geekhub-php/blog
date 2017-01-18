<?php
/**
 * Created by PhpStorm.
 * User: xfly3r
 * Date: 17.01.17
 * Time: 17:17
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends Controller
{
    /**
     * @Route("/admin/posts/{page}", name="not_approved_posts", requirements={"page": "\d+"})
     */
    public function postAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $postRepository = $em->getRepository('AppBundle:Post');

        $knpPaginator = $this->get('knp_paginator');

        $pagination = $knpPaginator->paginate($postRepository->findNotApprovedPosts(),
            $request->query->getInt('page', $page), 4
        );

        return $this->render('AppBundle:Post:notApprovedPosts.html.twig', [
            'posts' => $pagination,
        ]);
    }


}
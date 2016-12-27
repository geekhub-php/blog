<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends Controller
{
    /**
     * @param int $id
     * @return array
     *
     * @Route("articles/{id}", name="view_article", requirements={"\d+"})
     */
    public function viewAction(Article $article, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (!$article) {
            throw new NotFoundHttpException('Article is not exist!');
        }

        return $this->render('AppBundle:post:view.html.twig', array(
            'article' => $article
        ));
    }

     /**
     * @Route("/{page}", name="homepage", requirements={"page": "\d+"})
     *
     * @param $request
     * @param $page
     *
     * @return Response
     */
    public function indexAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findAll();

        if (!$article) {
            throw new NotFoundHttpException('Articles is not exist!');
        }
        $pagination = $this->pagination($article, $request->query->getInt('page', $page), 5);

        return $this->render('AppBundle:post:index.html.twig', [
            'articles' => $pagination,
        ]);
    }

    private function pagination($query, $currentPage, $perPage)
    {
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate($query, $currentPage, $perPage);
    }

}
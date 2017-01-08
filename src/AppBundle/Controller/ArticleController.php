<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Class ArticleController
 * @package AppBundle\Controller
 */
class ArticleController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("article/new", name="new_article")
     */
    public function newAction(Request $request){

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $article->setAuthor($em->getRepository('AppBundle:Author')->find(60));

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:post:new.html.twig', [
            'articleType' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $article
     * @return Response
     *
     * @Route("article/{id}/edit", name="edit_article", requirements={"\d+"})
     */
    public function editAction(Request $request, Article $article){

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();


            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('show_article', array(
                'id' => $article->getId()));
        }

        return $this->render('AppBundle:post:edit.html.twig', array(
            'articleType' => $form->createView(),
        ));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @Route("article/{id}", name="show_article", requirements={"\d+"})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (!$article) {
            throw new NotFoundHttpException('Article is not exist!');
        }

        return $this->render('AppBundle:post:show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @param Request $request
     * @param int $page
     * @return Response
     *
     * @Route("/{page}", name="homepage", requirements={"page": "\d+"})
     */
    public function indexAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        if (!$articles) {
            throw new NotFoundHttpException('Articles is not exist!');
        }

        $pagination = $this->pagination($articles, $request->query->getInt('page', $page), 5);

        return $this->render('AppBundle:post:index.html.twig', [
            'articles' => $pagination,
        ]);
    }

    private function pagination($query, $currentPage, $perPage)
    {
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate($query, $currentPage, $perPage);
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("article/{id}/delete", name="article_delete", requirements={"\d+"})
     */
    public function deleteAction(Article $article){

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
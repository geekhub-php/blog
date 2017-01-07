<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController.
 */
class ArticleController extends Controller
{
    /**
     * @param $request
     * @Route("/article/new", name="new_article")
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $article = $form->getData();

            if (!$article->getImage()) {
                $article->setImage('50708_1280x720-318x180.jpg');
            }

            $article->setAuthor($em->getRepository('AppBundle:Author')
                ->find(11));

            $em->persist($article);

            $em->flush();

            $this->get('app.notifier')
                ->newArticleNotify($article, $article->getAuthor());

            return $this->redirectToRoute('homepage');
        }

        return $this->render(':Article:new.html.twig', [
            'articleType' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{page}", name="homepage", requirements={"page": "\d+"})
     *
     * @param $request
     * @param $page
     *
     * @return Response
     */
    public function listAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')
            ->findAllOrdered();

        if (!$articles) {
            throw new NotFoundHttpException('Noooo!');
        }

        $pagination = $this->get('knp_paginator')
            ->paginate($articles,
                $request->query->getInt('page', $page), 5);

        return $this->render('Article/list.html.twig', [
        'articles' => $pagination,
    ]);
    }

    /**
     * @param $request
     * @param $article
     * @Route("/article/{id}/edit", name="edit_article")
     *
     * @return Response
     */
    public function editAction(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($article);

            $em->flush();

            $this->get('app.notifier')
                ->editArticleNotify();

            return $this->redirectToRoute('show_article', ['id' => $article->getId()]);
        }

        return $this->render(':Article:edit.html.twig', [
            'articleType' => $form->createView(),
        ]);
    }

    /**
     * @param Request      $request
     * @param Article|null $article
     * @param int          $page
     * @Route("/article/{id}/{page}", name="show_article", requirements={"id": "\d+", "page": "\d+"})
     *
     * @return Response
     */
    public function showAction(Request $request, Article $article = null, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')
            ->findByIdWithJoins($article);
        if (!$article) {
            throw new NotFoundHttpException('Article is not exist!');
        }

        $newCommentForm = $this->get('app.form_manager')
            ->newCommentForm($request, $article);

        $removeArticleForm = $this->get('app.form_manager')
            ->removeArticle($request, $article);

        if ($removeArticleForm->isSubmitted() && $removeArticleForm->isValid()) {
            $em->remove($article);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }elseif (!$newCommentForm instanceof Form){
            return $this->redirect($newCommentForm);
        }

        $comments = $article->getComments();

        $pagination = $this->get('knp_paginator')
            ->paginate($comments, $request->query->getInt('page', $page), 5);

        return $this->render('Article/article.html.twig', [
            'article' => $article,
            'comments' => $pagination,
            'commentType' => $newCommentForm->createView(),
            'removeArticleType' => $removeArticleForm->createView()
        ]);
    }

    /**
     * @return Response
     */
    public function topArticlesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AppBundle:Article')
           ->findTopFive();

        return $this->render(':Article:top.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @param int     $page
     * @return Response
     */
    public function searchAction(Request $request, $page = 1)
    {
        $result = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')
            ->search($request->query->get('q'));
        if (!$result) {
            $this->addFlash('failure', 'Nothing found');

            return $this->listAction($request);
        } else {
            $pagination = $this->get('knp_paginator')
                ->paginate($result, $request->query->getInt('page', $page), 5);
        }

        return $this->render('Article/list.html.twig', [
            'articles' => $pagination,
        ]);
    }

    /**
     * @Route("/article/tag/{tag}/{page}", name="tags", requirements={"page": "\d+"})
     *
     * @param Request $request
     * @param $tag
     * @param int $page
     *
     * @return Response
     */
    public function tagAction(Request $request, $tag, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('AppBundle:Tag')
            ->findByTag($tag);

        if (!$tag) {
            throw new NotFoundHttpException();
        }
        $pagination = $this->get('knp_paginator')
            ->paginate($tag->getArticles(), $request->query->getInt('page', $page), 5);

        return $this->render('Article/list.html.twig', [
            'articles' => $pagination,
        ]);
    }

    /**
     * @param Article $article
     * @Route("/article/{id}/like", name="article_like")
     * @return Response
     */
    public function likeAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $voices = $article->getVoices();
        $article->setVoices($voices + 1);
        $em->persist($article);
        $em->flush();
        return new Response($article->getVoices());
    }
}

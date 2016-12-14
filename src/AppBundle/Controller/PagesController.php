<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request, $page = 1)
    {

        $thisPage = $request->query->get('page');
        if($thisPage === null){
            $thisPage = $page;
        }
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->getAllPosts($thisPage);
        $limit = 3;
        $maxPages = ceil($posts->count() / $limit);

        return array('blogs' => $posts, 'maxPages' => $maxPages, 'thisPage' => $thisPage);
    }

    /**
     * @Route("/category/{slug}", name="category")
     */
    public function categoryAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:PostCategory')->findCategoryByName($slug);
        $posts = $category[0]->getPosts();

        return $this->render('AppBundle:Pages:index.html.twig', array('blogs' => $posts, 'maxPages' => 1));
    }

    /**
     * @Route("/{id}", name="id")
     */
    public function idAction($id)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($id);

        return $this->render('AppBundle:Pages:single.html.twig', array('blog' => $post));
    }

    /**
     * @Route("/tag/{slug}", name="tag")
     */
    public function tagAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('AppBundle:PostTag')->findTagByName($slug);
        $posts = $tag[0]->getPosts();

        return $this->render('AppBundle:Pages:index.html.twig', array('blogs' => $posts, 'maxPages' => 1));
    }

    /**
     * @return array
     * @Template()
     */
    public function sidebarAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findAll();

        return array('items' => $posts);
    }
}

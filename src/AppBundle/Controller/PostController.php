<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;

class PostController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/posts/all", name="all_posts")
     * @Template()
     *
     * @return array;
     */
    public function getAllAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $posts = $repository->findAll();

        return array('posts' => $posts);
    }

    /**
     * @Route("/findByCategory/{category}", name="findByCategory")
     * @Template()
     *
     * @param string $category;
     *
     * @return array;
     */
    public function findByCategoryAction($category)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Post');
        $posts = $repository->createQueryBuilder('p')
            ->innerJoin('p.category', 'c')
            ->andWhere('c.name = :category ')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();

        return array('posts' => $posts);
    }
}

<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Symfony\Component\VarDumper\Cloner\Data;

class CategoryController extends Controller
{
    /**
     *@Route("/categories/{id}", requirements={"id" = "\d+"}, defaults={"id" =0}, name="categories")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showSelectedCategoriesAction($id)
    {
        $category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }

        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }

        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findBy(array('category' => $id));

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle:Post');
        $count = $countCategores->getCountCategories($categories);

        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => $category, ));
    }
}

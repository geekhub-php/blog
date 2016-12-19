<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Entity\Comment;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\VarDumper\Cloner\Data;
use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\Request;

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
            ->findBy(array('category' =>$id));

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }

        //dump($categories);
        //return new Response('Saved new product with id ' . $categories);
        return $this->render('default/index.html.twig', array('data' =>$posts,
            'categories' => $categories, 'nameCategories' => $category, ));


    }


}
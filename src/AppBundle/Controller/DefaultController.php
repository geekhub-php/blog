<?php

namespace AppBundle\Controller;

use AppBundle\Form\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post\Post;
use Symfony\Component\VarDumper\Cloner\Data;
use AppBundle\Form\CategoryType;
use AppBundle\Form\PostType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Padam87\SearchBundle\Filter\Filter;
use Elastica\Query\QueryString;
use Doctrine\ORM\Query;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="welcome")
     */
    public function indexAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }

        $posts = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);





        //echo gettype($categories);
        //echo serialize($count);

//test using paginator bundle
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
//dump($pagination);
        // parameters to template
        //return $this->render('AcmeMainBundle:Article:list.html.twig', array('pagination' => $pagination));

        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => array('name' => 'last posts'),
            'pagination' => $pagination, 'tags'=>$tags,));
    }



    /**
     *@Route("/contacts", name="contacts")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showContactsAction()
    {
        return $this->render('default/contacts.html.twig');
    }

    /**
     *@Route("/search", name="search")
     * @Method({"POST"})
     *
     * @param int $id
     *
     * @return object
     */
    public function searchAction()
    {
       $search= $_POST['go'];
       $data = array(1=>$search);
        //dump($search);
/*
        $resultEntity= new Post();
        $resultEntity->setDescription($search);
        $fm = $this->get('padam87_search.filter.manager');
        $filter = new Filter($resultEntity, 'AppBundle\\Entity\\Post\\Post', 'alias');
        $qb = $fm->createQueryBuilder($filter);
        dump($qb->getQuery()->getScalarResult());
*/


        $finder = $this->container->get('fos_elastica.finder.search.post');



        $posts = $finder->find($search);
        dump($posts);




        return $this->render('default/contacts.html.twig');
    }


}

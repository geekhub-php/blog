<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Post\Post;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
            ->findBy(array(), array('dataEdit' => 'DESC'));

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
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );

        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

//dump($tokenStorage->getToken());
        // parameters to template
        //return $this->render('AcmeMainBundle:Article:list.html.twig', array('pagination' => $pagination));

        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => array('name' => 'last posts'),
            'pagination' => $pagination, 'tags' => $tags,
            'userAcl' => $user,
             ));

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
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

        return $this->render('default/contacts.html.twig', array('userAcl' => $user));
    }

    /**
     *@Route("/search", name="search")
     * @Method({"POST", "GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function searchAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Category\\Category')
            ->findAll();

        if (!$categories) {
            throw $this->createNotFoundException(
                'No catefories'
            );
        }

        /*$posts = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Post\\Post')
            ->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        */

        $tags = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\Tag\\Tag')
            ->findAll();

        if (!$tags) {
            throw $this->createNotFoundException(
                'No tags'
            );
        }
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle\\Entity\\Post\\Post');
        $count = $countCategores->getCountCategories($categories);
        //service saved value search form, for plaginator
        $myService = $this->get('service_saved_input_value');
        $search = $myService->getValue();
        //using serch bundle- FOSElasticaBundle
        $finder = $this->container->get('fos_elastica.finder.search.post');
        $posts = $finder->find($search);

//test using paginator bundle
       $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
          $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/);
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();

        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => array('name' => 'Result search posts:'),
            'pagination' => $pagination, 'tags' => $tags,
            'userAcl' => $user, ));
    }
   /**
    *@Route("/Ajacs", name="ajacs")
    * @Method({"POST"})
    *
    * @return param json
    */
   public function updataAjaxAction(Request $request)
   {


       /*$post = $this->getDoctrine()
           ->getRepository('AppBundle\\Entity\\Post\\Post')
           ->findAll();
*/
       $data = $request->get('data');
       $data=json_decode($data);
      // $data = $request->request->get('data');
       //dump($data);
       //die;


       // dump($isAjax);
       return new JsonResponse(array('data'=>1 ));

   }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        //return new Response('<html><body>Admin page!</body></html>');
        return $this->render('admin/index_admin.html.twig', array('userAcl' => $user));
    }






}



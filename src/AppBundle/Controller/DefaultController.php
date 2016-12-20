<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Symfony\Component\VarDumper\Cloner\Data;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="welcome")
     */
    public function indexAction()
    {
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
            ->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                'No posts'
            );
        }
        $em = $this->getDoctrine()->getManager();

        $countCategores = $em->getRepository('AppBundle:Post');
        $count = $countCategores->getCountCategories($categories);





        //echo gettype($categories);

        echo serialize($count);

        return $this->render('default/index.html.twig', array('data' => $posts,
            'categories' => $count, 'nameCategories' => array('name' => 'last posts'), ));
    }

    /**
     *@Route("/most_read", name="mostRead")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showMostReadAction()
    {
        $dataOptions = new ModelNima();

        return $this->render('default/mostRead.html.twig', array('data' => $dataOptions->getRevuePosts('most_read'),
            'categories' => $dataOptions->getCategories(), 'nameCategories' => 'most read categories', ));
    }
    /**
     *@Route("/most_commented", name="most_commented")
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return object
     */
    public function showMostCommentedAction()
    {
        $dataOptions = new ModelNima();


        return $this->render('default/mostRead.html.twig', array('data' => $dataOptions->getRevuePosts('most_commented'),
            'categories' => $dataOptions->getCategories(), 'nameCategories' => 'most commented caegories', ));
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
}

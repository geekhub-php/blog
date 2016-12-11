<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        $post = new Category();
        $post->setName('Jora');
        $post->setDescription('Danya');

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        return array();
    }
}
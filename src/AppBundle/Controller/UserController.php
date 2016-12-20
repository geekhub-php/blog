<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Common\Collections\Criteria;

class UserController extends Controller
{
    /**
     * Show user
     *
     * @Route("/user/{id}", name="show_user", requirements={"id": "\d+"} )
     * @Template()
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $userRepository = $em->getRepository('AppBundle:User');
        $categoryRepository = $em->getRepository('AppBundle:Category');

        $user = $userRepository->find($request->get('id'));
        $categories = $categoryRepository->findAll();
        $criteria = Criteria::create()
            ->orderBy(array("id" => Criteria::DESC))
            ->setMaxResults(5);
        $lastPosts = $user->getPosts()->matching($criteria);

        return $this->render('AppBundle:User:show.html.twig', [
            'user' => $user,
            'categories' => $categories,
            'lastPosts' => $lastPosts,
        ]);
    }
}

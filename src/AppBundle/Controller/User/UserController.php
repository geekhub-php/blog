<?php

namespace AppBundle\Controller\User;

use AppBundle\Entity\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * User controller.
 *
 * @Route("user_user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User\User')->findAll();

        return $this->render('user/user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        return $this->render('user/user/show.html.twig', array(
            'user' => $user,
        ));
    }
}

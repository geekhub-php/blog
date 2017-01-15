<?php

namespace AppBundle\Controller\User;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\HttpFoundation\Request;


class UserFormController extends Controller
{
    /**
     *@Route("/admin/show_all_forms_user", name="show_all_forms_user")
     * @Method({"GET", "POST"})
     */
    public function showAllPostFormAction(Request $request)
    {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle\\Entity\\User\\User')
            ->findAll();
        $user = new User\User();
        $form = $this->createForm(UserType::class, $user, [
            'em' => $this->getDoctrine()->getManager(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);

            return $this->redirectToRoute('welcome');
        }

        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        return $this->render('admin/crud_form_user.html.twig', array(
            'users' => $users,
            'user' => $user,
            'form' => $form->createView(),
            'userAcl'=>$user,
        ));
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserBloger;
use AppBundle\Entity\UserGuest;
use AppBundle\Form\UserType;
use AppBundle\Form\UserForAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends Controller
{
    /**
     * Creates a new user entity.
     *
     * @Route("/user/create/{slug}", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newUserBlogerAction(Request $request, $slug)
    {
        if ($slug == 'guest') {
            $user = new UserGuest();
        } else {
            $user = new UserBloger();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.dbManager')->save($user);
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Pages:registryform.html.twig', array(
            'form' => $form->createView(), 'slug' => $slug,
        ));
    }

    /**
     * Update a user entity.
     *
     * @Route("/user/update/{id}", name="user_update")
     * @Method({"GET", "POST"})
     * @ParamConverter("user", class="AppBundle:User")
     */
    public function updateUserAction(Request $request, User $user)
    {
        if ($this->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.dbManager')->update();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Pages:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Update a user entity by admin.
     *
     * @Route("/user/update_by_admin/{id}", name="user_update_byadmin")
     * @Method({"GET", "POST"})
     * @ParamConverter("user", class="AppBundle:User")
     */
    public function updateUserByAdminAction(Request $request, User $user)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
        if($user->isEnabled()){
            $user->setIsEnabled(false);
        }else{
            $user->setIsEnabled(true);
        }
        $form = $this->createForm(UserForAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.dbManager')->update();

            return $this->redirectToRoute('admin');
        }

        return $this->render('AppBundle:Pages:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Delete user.
     *
     * @Route("/user/delete/{id}", name="delete_user")
     * @Method({"GET", "POST"})
     * @ParamConverter("user", class="AppBundle:User")
     */
    public function deleteUserAction(Request $request, User $user)
    {
        if (($this->getUser() !== $user) ||
            $this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.dbManager')->delete($user);

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('AppBundle:Pages:form.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}

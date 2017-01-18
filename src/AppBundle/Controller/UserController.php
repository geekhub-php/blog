<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Form\LoginForm;
use AppBundle\Form\Search\SearchUserType;
use AppBundle\Form\UserType;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class UserController extends Controller
{

    /**
     * Show user list
     *
     * @Route("/user", name="user_list")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('AppBundle:User:index.html.twig', [
            'users' => $users,
            'categories' => $categories,
        ]);
    }

    /**
     * Show user
     *
     * @Route("/user/{id}", name="user_show", requirements={"id": "\d+"} )
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

        return $this->render('AppBundle:User:show.html.twig', [
            'user' => $user,
            'categories' => $categories,
            'lastPosts' => $user->getPosts()->matching($criteria),
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/user/login", name="user_login")
     */
    public function loginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);
        return $this->render('AppBundle:User:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logoutAction()
    {
    }

    /**
     * Registering a new user
     *
     * @Route("/user/registration", name="user_registration")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles('ROLE_USER');
            $em->persist($user);
            $em->flush();

            $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main');
            return $this->redirectToRoute('user_show', array('id' => $user->getId(),
                'status' => 'created',
            ));
        }

        return $this->render('AppBundle:User:create.html.twig', array(
                'user' => $user,
                'form' => $form->createView(),
            )
        );
    }


    /**
     * Editing user
     *
     * @Route("/user/{id}/edit", name="user_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm(UserType::class, $user);
        $deleteForm = $this->createDeleteForm($user);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId(),
                'status' => 'edited',
            ));
        }

        return $this->render('AppBundle:User:edit.html.twig', array(
            'user' => $user,
            'form' => $editForm->createView(),
            'categories' => $categoryRepository->findAll(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a author entity.
     *
     * @Route("/user/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_list');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     *
     * @Route("/search/user", name="user_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository('AppBundle:Category');

        $result = $this->get('app.form_manager')
            ->createSearchForm($request, 'AppBundle:User');

        if ($result['valid'] == true) {
            return $this->render('AppBundle:User:search.html.twig', array(
                'users' => $result['data'],
                'categories' => $categoryRepository->findAll(),
                'form' => $result['form']->createView(),
            ));
        }

        return $this->render('AppBundle:User:search.html.twig', array(
                'categories' => $categoryRepository->findAll(),
                'form' => $result['form']->createView(),
                'users' => null,
            )
        );
    }
}

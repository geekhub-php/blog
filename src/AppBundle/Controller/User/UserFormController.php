<?php

namespace AppBundle\Controller\User;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

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

            $test_password = '1';
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $test_password);
            $user->setPassword($password);
            $user->setRating('0');
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
    /**
     * @Route("/admin/user_edit/{id}", requirements={"id" = "\d+"}, defaults={"id" =1}, name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editUserAction(Request $request, User\User $user, $id)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm(UserType::class, $user, [
            'em' => $this->getDoctrine()->getManager(),
        ]);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_all_forms_user', array('id' => $user->getId()));
        }
        $userEdits=$user;
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();


        $inspection = $this->get('service_inspection_id_route');
        $inspection->setValue($userEdits,"null", $user);
        $resultInspection=$inspection->getValue();
        return $this->render('admin/edit_form_user.html.twig', array(
            'post' => $user,
            // 'id' =>$id,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'userAcl'=>$user,
        ));
    }
    /**
     * Deletes a post entity.
     *
     * @Route("/admin/user_delete/{id}", name="user_delete")
     * @Method("Delete")
     */
    public function deleteUserAction(Request $request, User\User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush($user);
        }

        return $this->redirectToRoute('show_all_forms_user');
    }

    private function createDeleteForm(User\User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


}

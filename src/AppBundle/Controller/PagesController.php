<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Form\PostForm;
use AppBundle\Model\PostModel;
use AppBundle\Model\RandomDataModel;

class PagesController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $file_name = $this->container->getParameter('storage');
        $model = new PostModel();
        $result = $model->get($file_name);
        $model = new RandomDataModel();
        $images = $model->getImages(6);

        return array('blogs' => $result, 'images' => $images);
    }

    /**
     * @Route("/about", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        $model = new RandomDataModel();
        $images = $model->getImages(4);

        return array('images' => $images);
    }

    /**
     * @Route("/contact", name="contact")
     * @Template()
     */
    public function contactAction()
    {
        return array('array' => null);
    }

    /**
     * @return array
     * @Template()
     */
    public function sidebarAction()
    {
        $model = new RandomDataModel();
        $images = $model->getImages(6);
        $description = $model->getDescription(6);
        for ($i = 0; $i < 6; ++$i) {
            $items[$i]['image'] = $images[$i];
            $items[$i]['text'] = $description[$i];
        }

        return array('items' => $items);
    }

    /**
     * @Route("/post_form", name="post_form")
     * @Method ({"GET", "POST"})
     */
    public function postFormAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostForm::class, $post);

        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $post = $form->getData();
                $file_name = $this->container->getParameter('storage');
                $model = new PostModel();
                $model->save($post, $file_name);

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('AppBundle:Pages:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

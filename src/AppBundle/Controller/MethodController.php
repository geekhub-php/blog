<?php

namespace AppBundle\Controller;

use AppBundle\Model\MethodModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class MethodController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/post/add", name="post")
     * @Method({"POST"})
     */
    public function postAction()
    {
        if (!empty($_POST)) {
            $model = $this->get('model.service');
            $data = $model->createRecord($_POST);
        }

        return new JsonResponse($data);
    }


    /**
     * @Route("/post/{id}", name="delete")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $model = $this->get('model.service');
        $data = $model->deleteRecord($id);

        return new JsonResponse();
    }


    /**
     * @Route("/post", name="getAll")
     * @Method({"GET"})
     */
    public function getAction()
    {
        $model = $this->get('model.service');
        $data = $model->showAllRecords();

        return new JsonResponse($data);
    }

    /**
     * @Route("/post/{id}", name="getId")
     * @Method({"GET"})
     */
    public function getIdAction($id)
    {
        $model = $this->get('model.service');
        $data = $model->showRecord($id);

        return new JsonResponse($data);
    }

    /**
     * @Route("/post/{id}", name="put")
     * @Method({"PUT"})
     */
    public function putAction($id)
    {
        $model = $this->get('model.service');
        $data = $model->editRecord($id);

        return new JsonResponse($data);
    }

    /**
     * @Route("/post/{id}", name="patch")
     * @Method({"PATCH"})
     */
    public function patchAction($id)
    {
        $model = $this->get('model.service');
        $data = $model->patchRecord($id);

        return new JsonResponse($data);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Model\MethodModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class NewsController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('@App/base.html.twig');
    }

    /**
     * @Route("/news/add", name="addNews")
     * @Method({"POST"})
     */
    public function addAction()
    {
        if (!empty($_POST)) {
            $model = $this->get('model.service');
            $data = $model->createRecord($_POST);
        }

        return $this->getAllAction();
    }


    /**
     * @Route("/news/{id}", name="deleteNews")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $model = $this->get('model.service');
        $data = $model->deleteRecord($id);

        return new JsonResponse();
    }


    /**
     * @Route("/news", name="allNews")
     * @Method({"GET"})
     * @Template()
     */
    public function getAllAction()
    {
        $model = $this->get('model.service');
        $data = $model->showAllRecords();

        return array ('data' => $data);
    }

    /**
     * @Route("/news/{id}", name="newsId")
     * @Method({"GET"})
     */
    public function getIdAction($id)
    {
        $model = $this->get('model.service');
        $data = $model->showRecord($id);

        return new JsonResponse($data);
    }

    /**
     * @Route("/news/{id}", name="edit")
     * @Method({"PUT"})
     */
    public function editAction($id)
    {
        $model = $this->get('model.service');
        $data = $model->editRecord($id);

        return new JsonResponse($data);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Model\NewsModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class NewsController extends Controller
{

    /**
     * @Route("/news/add", name="addNews")
     * @Method({"POST"})
     */
    public function addAction()
    {
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

        return $this->render('@App/News/getAll.html.twig');
    }

    /**
     * @Route("/news/{id}", name="newsId")
     * @Method({"GET"})
     */
    public function getIdAction($id)
    {
    }

    /**
     * @Route("/news/{id}", name="delete")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $model = $this->get('model.service');
        $model->deleteRecord($id);

        return $this->render('@App/base.html.twig');

    }
}

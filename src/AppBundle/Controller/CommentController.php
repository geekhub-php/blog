<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CommentController extends Controller
{
    /**
     * @Route("/", name="commentsList")
     * @Method({"GET"})
     */
    /*public function listAction()
    {
        return $this->render();
    }*/
}

<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 13.01.17
 * Time: 5:54
 */

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AjacsRequestListener
{
        public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->isXmlHttpRequest()&& ($_SERVER['PATH_INFO']=='/Ajacs')){
            //if ($_SERVER['PATH_INFO']!='/Ajacs')
           // $event->setResponse(new Response('Test', 401));
                die("test");
        }
    }
}
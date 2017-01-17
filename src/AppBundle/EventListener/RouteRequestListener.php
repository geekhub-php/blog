<?php
/**
 * Created by PhpStorm.
 * User: nima
 * Date: 13.01.17
 * Time: 5:54.
 */

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RouteRequestListener
{
    private $token_storage;

    public function __construct(TokenStorageInterface $token_storage)
    {
        $this->token_storage = $token_storage;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        /*$request = $event->getRequest();
        $user = $this->token_storage->getToken();

        if ($user->getUser() == 'anon.' && $_SERVER['PATH_INFO'] == '/admin') {
            $response = new Response('Forbidden', 401);
            $event->setResponse($response);
        }
        */
    }
}

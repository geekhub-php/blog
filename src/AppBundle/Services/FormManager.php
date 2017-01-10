<?php

namespace AppBundle\Services;

use AppBundle\Form\Search\SearchType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class FormManager
{
    private $doctrine;

    private $formFactory;

    public function __construct(RegistryInterface $doctrine, FormFactoryInterface $formFactory)
    {
        $this->doctrine = $doctrine;
        $this->formFactory = $formFactory;
    }

    public function createSearchUserForm(Request $request)
    {
        $searchUserForm = $this->formFactory->create(SearchType::class);

        $searchUserForm->handleRequest($request);

        if ($searchUserForm->isSubmitted() && $searchUserForm->isValid()) {
            $data = $searchUserForm->getData();
            $result = $this->doctrine
                ->getRepository('AppBundle:User')
                ->search($data['text']);
            return array(
                'valid' => true,
                'users' => $result,
                'form' => $searchUserForm,
            );
        }

        return array(
            'valid' => null,
            'result' => null,
            'form' => $searchUserForm,
        );
    }

    public function createSearchPostForm(Request $request)
    {
        $searchPostForm = $this->formFactory->create(SearchType::class);

        $searchPostForm->handleRequest($request);

        if ($searchPostForm->isSubmitted() && $searchPostForm->isValid()) {
            $data = $searchPostForm->getData();
            $result = $this->doctrine
                ->getRepository('AppBundle:Post')
                ->search($data['text']);
            return array(
                'valid' => true,
                'posts' => $result,
                'form' => $searchPostForm,
            );
        }

        return array(
            'valid' => null,
            'result' => null,
            'form' => $searchPostForm,
        );
    }
}

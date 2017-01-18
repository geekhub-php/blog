<?php

namespace AppBundle\Services;

use AppBundle\Entity\Post;
use AppBundle\Form\CategoryType;
use AppBundle\Form\PostType;
use AppBundle\Form\Search\SearchType;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class FormManager implements FormManagerInterface
{
    private $doctrine;

    private $formFactory;

    private $router;

    public function __construct(RegistryInterface $doctrine,
                                FormFactoryInterface $formFactory,
                                RouterInterface $router)
    {
        $this->doctrine = $doctrine;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function createSearchForm(Request $request, $repository)
    {
        $searchForm = $this->formFactory->create(SearchType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();
            $result = $this->doctrine
                ->getRepository($repository)
                ->search($data['text']);
            return array(
                'valid' => true,
                'data' => $result,
                'form' => $searchForm,
            );
        }

        return array(
            'valid' => false,
            'result' => null,
            'form' => $searchForm,
        );
    }

    /**
     * Creates a new form for Post
     *
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createNewPostForm(Request $request, $user)
    {
        $createForm = $this->formFactory->create(PostType::class);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $post = $createForm->getData();

            $em = $this->doctrine->getManager();
            $post->setUser($user);
            $em->persist($post);
            $em->flush();
            return $this->router->generate('post_show', array(
                'id' => $post->getId(),
                'status' => 'created',
            ));
        }

        return $createForm;
    }

    /**
     * Creates a new form for Post
     *
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createNewCategoryForm(Request $request)
    {
        $createForm = $this->formFactory->create(CategoryType::class);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $category = $createForm->getData();

            $em = $this->doctrine->getManager();
            $em->persist($category);
            $em->flush();
            return $this->router->generate('category_show', array(
                'id' => $category->getId(),
            ));
        }

        return $createForm;
    }

    public function createEditForm(Request $request, $formType, $entity, $controllerName)
    {
        $editForm = $this->formFactory->create($formType, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->doctrine->getManager();
            $em->flush();

            switch($controllerName)
            {
                case 'post':
                    return $this->router->generate('post_show', array(
                        'id' => $entity->getId(),
                    ));
                    break;
                case 'category':
                    return $this->router->generate('category_show', array(
                        'id' => $entity->getId(),
                    ));
                    break;
            }
        }

        return $editForm;
    }

    public function createDeleteForm(Request $request, $formType, $entity, $controllerName)
    {
        $deleteForm = $this->formFactory->createBuilder()
            ->setAction($this->router->generate('post_delete', array(
                'id' => $entity->getId(),
            )))
            ->setMethod('DELETE')
            ->getFormConfig()
            ;
    }
}

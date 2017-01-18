<?php

namespace AppBundle\Services;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

interface FormManagerInterface
{

    public function createSearchForm(Request $request, $repository);

    public function createNewPostForm(Request $request, $user);

    public function createNewCategoryForm(Request $request);

    public function createEditForm(Request $request, $formType, $entity, $controllerName);

    public function createDeleteForm(Request $request, $formType, $entity, $controllerName);
}
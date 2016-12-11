<?php
namespace AppBundle\Controller;

use BlogBundle\Entity\PostEntity;
use BlogBundle\Entity\CategoryEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Matches /category/* and get posts from category #{id}
     *
     * @Route("/category/{id}", name="category_show", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $entity = new PostEntity();
        $posts = $entity->getPosts();
        return $this->render('@Blog/Post/index.html.twig', array(
            'title' => 'Category #' . $request->get('id'),
            'posts' => $posts,
            'categories' => CategoryEntity::getCategories(),
            'page' => 'category',
        ));
    }
}
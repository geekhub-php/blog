<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/", name="postsList")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function listAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->getPostsList();

        return $this->render('AppBundle:Post:list.html.twig', array(
                'posts' => $posts
            )
        );
    }

    /**
     * @Route("/posts/view/{id}", name="postsView")
     * @Method({"GET"})
     */
    public function viewAction($id)
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')
            ->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        return $this->render('AppBundle:Post:view.html.twig', array(
                'post' => $post
            )
        );
    }

    /**
     * @Route("/posts/create", name="postsCreate")
     * @Method({"GET"})
     */
    public function createAction()
    {
        $author = $this->getDoctrine()
            ->getRepository('AppBundle:Author')
            ->find(1);

        $post = new Post();
        $post->setTitle('Pellentesque in metus accumsan, commodo lacus sit amet, feugiat mi.');
        $post->setContent('Aenean sagittis dolor eget massa aliquam, non dignissim leo iaculis. Cras vel massa a nisi dictum malesuada non nec ex. Integer eros erat, hendrerit vel tellus eu, posuere tristique turpis. Ut mattis arcu nec tempor interdum. Nunc dui dui, lobortis non massa ut, vestibulum venenatis dolor. Etiam pretium turpis nisi, in egestas diam accumsan vitae. Fusce placerat arcu eget quam bibendum, vel auctor nibh mattis.
                           Pellentesque in metus accumsan, commodo lacus sit amet, feugiat mi. Vestibulum quis augue quis nunc porta lobortis. Proin sollicitudin suscipit iaculis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec erat elit, porta nec aliquet nec, cursus ut nulla. Cras at sodales velit. Aenean commodo laoreet suscipit. Etiam ac commodo tortor. Phasellus mollis malesuada metus. Duis varius bibendum vehicula.
                           Morbi pretium ipsum sed finibus blandit. Aliquam porttitor eget tortor eget dignissim. Donec gravida, massa sed gravida tincidunt, risus erat vestibulum arcu, at bibendum tortor augue eu dui. Ut nec odio fermentum, congue mi in, convallis justo. Ut vitae dolor non orci consequat pulvinar. Nulla ac accumsan ante, quis pharetra ante. Aenean feugiat neque eget mi venenatis, non efficitur nulla vehicula. Vivamus vulputate dapibus sapien nec cursus. Suspendisse id purus leo. Duis quis lacus convallis, eleifend est vitae, auctor ligula. Curabitur et scelerisque odio, eu aliquam lectus. Integer a ex at ligula tincidunt placerat.');
        $post->setDescripton('Pellentesque in metus accumsan, commodo lacus sit amet, feugiat mi.');
        $post->setVisibility(true);
        $post->setAuthor($author);
        $post->setCreateAt(new \DateTime("now"));

        $em = $this->getDoctrine()
            ->getEntityManager();

        $em->persist($post);
        $em->flush();
        return new Response('Saved new post with id '.$post->getId());
    }
}

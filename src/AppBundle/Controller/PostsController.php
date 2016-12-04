<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Post;
use Faker\Factory;

class PostsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/posts/all", name="all_posts")
     * @Template()
     *
     * @return array;
     */
    public function getAllAction()
    {
        $faker = Factory::create();

        return array('posts' => array(
            new Post(1, $faker->sentence, $faker->text($maxNbChars = 100), $faker->name, $faker->dateTimeBetween($startDate = '-3 month', $endDate = 'now')),
            new Post(2, $faker->sentence, $faker->text, $faker->name, $faker->dateTimeBetween($startDate = '-3 month', $endDate = 'now')),
            new Post(3, $faker->sentence, $faker->text, $faker->name, $faker->dateTimeBetween($startDate = '-3 month', $endDate = 'now')),
            new Post(4, $faker->sentence, $faker->text, $faker->name, $faker->dateTimeBetween($startDate = '-3 month', $endDate = 'now')),
            new Post(5, $faker->sentence, $faker->text, $faker->name, $faker->dateTimeBetween($startDate = '-3 month', $endDate = 'now')),
    ));
    }
    /**
     * @Route("/posts/{id}", name="post_detail", requirements={"id": "\d+"})
     * @Template()
     *
     * @param int       $id;
     * @param string    $title;
     * @param string    $text;
     * @param string    $author;
     * @param \DateTime $postedOnDate;
     *
     * @return Post;
     */
    public function getOneAction($id)
    {
        $faker = Factory::create();
        $post = new Post($id, $faker->sentence, $faker->text($maxNbChars = 2000), $faker->name, $faker->dateTimeBetween($startDate = '-3 month', $endDate = 'now'));

        return array('post' => $post);
    }
}

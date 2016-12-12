<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;
use AppBundle\Entity\Author;
use AppBundle\Entity\User;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Category;
use Faker;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        // adding categories
        $categories = array('Sport', 'Show Business', 'Economy', 'Fashion', 'Politics');
        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }
        $manager->flush();
        // adding tags
        $tags = array('B.Obama', 'D.Trump', 'Elections', 'USA', 'Ukraine', 'Football', 'Kyiv');
        foreach ($tags as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);
        }
        $manager->flush();

        // adding rest of data
        for ($i = 0; $i < 30; ++$i) {

            // adding new user
            $user = new User();
            $username = $faker->word.$faker->randomDigit.$faker->randomDigit;
            $user->setUserName($username);
            $user->setPassword($faker->shuffle($username));

            // adding new author
            $author = new Author();
            $author->setFirstName($faker->firstName);
            $author->setLastName($faker->lastName);
            $author->setUserName($user);

            // adding new posts
            $categoryRepository = $manager->getRepository('AppBundle:Category');
            $post1 = new Post();
            $post1->setTitle($faker->sentence);
            $post1->setContent($faker->text(200));
            $post1->setAuthor($author);
            $category1 = $categoryRepository->findOneBy(array('id' => $faker->numberBetween($min = 1, $max = 5)));
            $post1->setCategory($category1);
            $post2 = new Post();
            $post2->setTitle($faker->sentence);
            $post2->setContent($faker->text(200));
            $post2->setAuthor($author);
            $category2 = $categoryRepository->findOneBy(array('id' => $faker->numberBetween($min = 1, $max = 5)));
            $post2->setCategory($category2);
            $manager->persist($author);
            $manager->persist($user);
            $manager->persist($post1);
            $manager->persist($post2);
        }
        $manager->flush();
    }
}

<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;
use AppBundle\Entity\Author;
use AppBundle\Entity\User;
use Faker;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 30; ++$i) {
            $faker = Faker\Factory::create();
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
            $post1 = new Post();
            $post1->setTitle($faker->sentence);
            $post1->setContent($faker->text(200));
            $post1->setAuthor($author);
            $post2 = new Post();
            $post2->setTitle($faker->sentence);
            $post2->setContent($faker->text(200));
            $post2->setAuthor($author);
            $manager->persist($author);
            $manager->persist($user);
            $manager->persist($post1);
            $manager->persist($post2);
        }
        $manager->flush();
    }
}

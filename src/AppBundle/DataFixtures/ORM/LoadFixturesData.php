<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;
use AppBundle\Entity\User;
use Faker\Factory;

class LoadFixturesData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 1; $i < 6; $i++) {

            //Adding categories
            $category = new Category();
            $category->setName($faker->title);
            $category->setDescription($faker->sentence(10));

            $manager->persist($category);

            // Adding users
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword(md5($faker->password(6)));
            $user->setEmail($faker->email);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);

            $manager->persist($user);
        }
        $manager->flush();

        $categoryRepository = $manager->getRepository('AppBundle:Category');
        $userRepository = $manager->getRepository('AppBundle:User');

        for ($i = 1; $i < 6; $i++) {

            $category = $categoryRepository->find(rand(1, 5));
            $user = $userRepository->find(rand(1, 5));

            // Adding Posts
            $post = new Post();

            $post->setTitle($faker->sentence);
            $post->setText($faker->text(100));
            $post->setCategory($category);
            $post->setDateOfPublication(new \DateTime());
            $post->setUser($user);

            $manager->persist($post);

            //Adding Comments
            $comment = new Comment();

            $comment->setText($faker->text(50));
            $comment->setDateOfPublication(new \DateTime());
            $comment->setUser($user);

            $manager->persist($comment);
        }
        $manager->flush();
    }
}
<?php


namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use AppBundle\Entity\Author;
use AppBundle\Entity\Tags;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class DataLoad implements FixtureInterface
{
    public function load(ObjectManager $manager){

        $article = new Article();
        $article->setTitle("First Article");
        $article2 = new Article();
        $article2->setTitle("Second Article");

        $author = new Author();
        $author->setName("Oleksandr");
        $author->setLastName("Ocheretnyi");

        $user = new User();
        $user->setNickname("Accord");

        $author->setUser($user);

        $article->setAuthor($author);
        $article2->setAuthor($author);

        $tag_name = new Tags();
        $tag_name->setTagName("Tag sports");
        $tag_name2 = new Tags();
        $tag_name2->setTagName("Tag science");

        //$article->setTags($tag_name);



        $manager->persist($article);
        $manager->persist($article2);
        $manager->persist($author);
        $manager->persist($user);
        $manager->flush();



    }

}
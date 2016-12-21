<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Author;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAuthorData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $author = new Author();
        $author->setName('author');
        $author->setAge(20);
        $author->setPhoto('image');

        $author2 = new Author();
        $author2->setName('author2');
        $author2->setAge(23);
        $author2->setPhoto('image');

        $manager->persist($author);
        $manager->persist($author2);
        $manager->flush();
    }
}
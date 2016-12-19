<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Author;
use Faker;

class AuthorFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $a=rand(1, 10);

            $faker = Faker\Factory::create();

            $author = new author();
            $author->setName($faker->firstName);
            $author->setSurname($faker->lastName);
            $author->setEmail($faker->email);
            $author->setPhone($faker->phoneNumber);
            $author->setAddress($faker->streetAddress);
            $author->setUser($manager->merge($this->getReference("user-{$i}")));

            $manager->persist($author);

            $this->addReference("author-{$i}", $author);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2 ;
    }
}

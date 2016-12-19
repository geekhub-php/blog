<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Faker;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<=10; $i++) {
            $faker = Faker\Factory::create();

            $user = new user();
            $user->setLogin($faker->unique()->userName);
            $user->setPassword($faker->password);
            $manager->persist($user);

            $this->addReference("user-{$i}", $user);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 1;
    }
}

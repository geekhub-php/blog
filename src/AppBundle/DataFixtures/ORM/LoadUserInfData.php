<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\UserData;

class LoadUserInfData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new UserData();
        $user1->setUser('1');
        $user1->setEmail('john@email.com');

        $user2 = new UserData();
        $user2->setUser('2');
        $user2->setEmail('alice@email.com');

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}

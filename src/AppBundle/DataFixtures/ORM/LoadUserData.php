<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setNickName('bloger1');
        $user1->setFirstName('John');
        $user1->setRole($this->getReference('bloger'));
        $user1->setPassword('test1');

        $user2 = new User();
        $user2->setNickName('bloger2');
        $user2->setFirstName('Alice');
        $user2->setRole($this->getReference('bloger'));
        $user2->setPassword('test2');

        $user3 = new User();
        $user3->setNickName('some_user');
        $user3->setFirstName('Nick');
        $user3->setRole($this->getReference('user'));
        $user3->setPassword('test3');

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->flush();

        $this->addReference('bloger1', $user1);
        $this->addReference('bloger2', $user2);
        $this->addReference('some_user', $user3);
    }

    public function getOrder()
    {
        return 2;
    }
}

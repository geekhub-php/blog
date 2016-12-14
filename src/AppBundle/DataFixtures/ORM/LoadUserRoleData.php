<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\UserRole;

class LoadUserRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role1 = new UserRole();
        $role1->setRoleName('admin');

        $role2 = new UserRole();
        $role2->setRoleName('bloger');

        $role3 = new UserRole();
        $role3->setRoleName('user');

        $manager->persist($role1);
        $manager->persist($role2);
        $manager->persist($role3);
        $manager->flush();

        $this->addReference('admin', $role1);
        $this->addReference('bloger', $role2);
        $this->addReference('user', $role3);
    }

    public function getOrder()
    {
        return 1;
    }
}

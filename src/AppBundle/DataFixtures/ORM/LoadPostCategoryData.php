<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PostCategory;

class LoadPostCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category1 = new PostCategory();
        $category1->setCategoryName('Buying');

        $category2 = new PostCategory();
        $category2->setCategoryName('Cooking');

        $category3 = new PostCategory();
        $category3->setCategoryName('History');

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->flush();

        $this->addReference('buying', $category1);
        $this->addReference('cooking', $category2);
        $this->addReference('hystory', $category3);
    }

    public function getOrder()
    {
        return 4;
    }
}

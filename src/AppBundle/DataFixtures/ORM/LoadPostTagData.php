<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PostTag;

class LoadPostTagData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tag1 = new PostTag();
        $tag1->setName('arabica');

        $tag2 = new PostTag();
        $tag2->setName('robusta');

        $tag3 = new PostTag();
        $tag3->setName('liberica');

        $manager->persist($tag1);
        $manager->persist($tag2);
        $manager->persist($tag3);
        $manager->flush();

        $this->addReference('arab', $tag1);
        $this->addReference('robu', $tag2);
        $this->addReference('libe', $tag3);
    }

    public function getOrder()
    {
        return 4;
    }
}

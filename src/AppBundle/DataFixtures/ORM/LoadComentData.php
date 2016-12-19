<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Coment;

class LoadComentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $coment1 = new Coment();
        $coment1->setPost($this->getReference('post1'));
        $coment1->setUser($this->getReference('some_user'));
        $coment1->setContent('1Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam 
         mi quis accum san porta.');

        $coment2 = new Coment();
        $coment2->setUser($this->getReference('some_user'));
        $coment2->setContent('2Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam 
         mi quis accum san porta.');
        $coment2->setParentComent($coment1);

        $coment3 = new Coment();
        $coment3->setUser($this->getReference('some_user'));
        $coment3->setContent('3Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam 
         mi quis accum san porta.');
        $coment3->setParentComent($coment1);

        $manager->persist($coment1);
        $manager->persist($coment2);
        $manager->persist($coment3);
        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}

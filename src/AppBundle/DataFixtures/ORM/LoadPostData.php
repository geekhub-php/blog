<?php

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $post1 = new Post();
        $post1->setTitle('Some advices for buying');
        $post1->setBody('Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam 
         mi quis accum san porta.Quisque nec turpis nisi. Proin lobortis nisl ut orci euismod, et lobortis est 
         scelerisque. Sed eget volutpat ipsum. Integer fring illa leo porttitor, ultrices quam non, lobortis 
         ligula. Aliquam vel consequat arcu. On the other hand, we denounce with righteous indignation and 
         dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded 
         by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame 
         belongs to those who fail in their duty through weakness of will, which is the same as saying through 
         shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. The other hand,
          we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the 
          charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble 
          that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of 
          will, which is the same as saying through shrinking from toil and pain. These cases are perfectly 
          simple and easy to distinguish');
        $post1->setUser($this->getReference('bloger1'));
        $post1->setCategoty($this->getReference('buying'));
        $post1->addTag($this->getReference('arab'));
        $post1->addTag($this->getReference('robu'));

        $post2 = new Post();
        $post2->setTitle('Some advices for cooking');
        $post2->setBody('Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam 
         mi quis accum san porta.Quisque nec turpis nisi. Proin lobortis nisl ut orci euismod, et lobortis est 
         scelerisque. Sed eget volutpat ipsum. Integer fring illa leo porttitor, ultrices quam non, lobortis 
         ligula. Aliquam vel consequat arcu. On the other hand, we denounce with righteous indignation and 
         dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded 
         by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame 
         belongs to those who fail in their duty through weakness of will, which is the same as saying through 
         shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. The other hand,
          we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the 
          charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble 
          that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of 
          will, which is the same as saying through shrinking from toil and pain. These cases are perfectly 
          simple and easy to distinguish');
        $post2->setUser($this->getReference('bloger2'));
        $post2->setCategoty($this->getReference('cooking'));
        $post2->addTag($this->getReference('libe'));

        $post3 = new Post();
        $post3->setTitle('Some historical facts');
        $post3->setBody('Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. Nulla ante diam, interdum nec tempus eu, feugiat vel erat. Integer aliquam 
         mi quis accum san porta.Quisque nec turpis nisi. Proin lobortis nisl ut orci euismod, et lobortis est 
         scelerisque. Sed eget volutpat ipsum. Integer fring illa leo porttitor, ultrices quam non, lobortis 
         ligula. Aliquam vel consequat arcu. On the other hand, we denounce with righteous indignation and 
         dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded 
         by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame 
         belongs to those who fail in their duty through weakness of will, which is the same as saying through 
         shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. The other hand,
          we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the 
          charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble 
          that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of 
          will, which is the same as saying through shrinking from toil and pain. These cases are perfectly 
          simple and easy to distinguish');
        $post3->setUser($this->getReference('bloger1'));
        $post3->setCategoty($this->getReference('hystory'));
        $post3->addTag($this->getReference('arab'));
        $post3->addTag($this->getReference('robu'));
        $post3->addTag($this->getReference('libe'));

        $post4 = new Post();
        $post4->setTitle('Some historical facts');
        $post4->setBody('Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. ');
        $post4->setUser($this->getReference('bloger1'));
        $post4->setCategoty($this->getReference('hystory'));
        $post4->addTag($this->getReference('arab'));
        $post4->addTag($this->getReference('robu'));
        $post4->addTag($this->getReference('libe'));

        $post5 = new Post();
        $post5->setTitle('Some historical facts');
        $post5->setBody('Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. ');
        $post5->setUser($this->getReference('bloger1'));
        $post5->setCategoty($this->getReference('hystory'));
        $post5->addTag($this->getReference('arab'));
        $post5->addTag($this->getReference('robu'));
        $post5->addTag($this->getReference('libe'));

        $post6 = new Post();
        $post6->setTitle('Some historical facts');
        $post6->setBody('Cras consequat iaculis lorem, id vehicula erat mattis quis. Vivamus laoreet 
         velit justo, in ven e natis purus pretium sit amet. Praesent lectus tortor, tincidu nt in consectetur 
         vestibulum, ultrices nec neque. Praesent nec sagittis mauris. Fusce convallis nunc neque. Integer 
         egestas aliquam interdum. ');
        $post6->setUser($this->getReference('bloger1'));
        $post6->setCategoty($this->getReference('hystory'));
        $post6->addTag($this->getReference('arab'));
        $post6->addTag($this->getReference('robu'));
        $post6->addTag($this->getReference('libe'));

        $manager->persist($post1);
        $manager->persist($post2);
        $manager->persist($post3);
        $manager->persist($post4);
        $manager->persist($post5);
        $manager->persist($post6);
        $manager->flush();

        $this->addReference('post1', $post1);
        $this->addReference('post2', $post2);
        $this->addReference('post3', $post3);
    }

    public function getOrder()
    {
        return 6;
    }
}

<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Article;

class CommentFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<=50; $i++) {

            $a=rand(1,30);

            $comment = new Comment();
            $comment->setContent("Comment 1");
            $comment->setArticle($manager->merge($this->getReference("article-{$a}")));
            $manager->persist($comment);

        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}



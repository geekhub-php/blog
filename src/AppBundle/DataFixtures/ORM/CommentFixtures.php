<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Comment;
use Faker;

class CommentFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i=1; $i<=150; $i++) {
            //for articles
            $a=rand(1, 40);

            //for authors
            $b=rand(1, 10);

            $comment = new Comment();
            $comment->setContent($faker->text($maxNbChars = 100));
            $comment->setArticle($manager->merge($this->getReference("article-{$a}")));
            $comment->setAuthor($manager->merge($this->getReference("author-{$b}")));
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}

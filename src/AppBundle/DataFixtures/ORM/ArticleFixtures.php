<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Article;
use Faker;

class ArticleFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 40; $i++) {
            $c = rand(1,15);
            $article = new article();
            $article->setTitle($faker->catchPhrase);
            $article->setContent($faker->text($maxNbChars = 1000));
            $article->setImage("image{$i}.jpg");
            $article->setDate($faker->dateTimeThisYear($max = "now"));
            $article->setCategory($manager->merge($this->getReference("category-{$c}")));
             for ($n=1; $n<=rand(1,3); $n++) {
                 $a=rand(1,10);
                 $article->addAuthor($this->getReference("author-{$a}"));
                 $t=rand(1,20);
                 $article->addTag($this->getReference("tag-{$t}"));
             }
            $manager->persist($article);

            $this->addReference("article-{$i}", $article);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}

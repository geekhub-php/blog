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

        for ($i = 1; $i <= 30; $i++) {
            $article = new article();
            $article->setTitle($faker->catchPhrase);
            $article->setContent($faker->text($maxNbChars = 1000));
            $article->setImage("image{$i}.jpg");
            $article->setDate($faker->dateTimeThisYear($max = "now"));
            $manager->persist($article);


            $this->addReference("article-{$i}", $article);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}

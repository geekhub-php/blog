<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Article;
use Faker;

class ArticleFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            $article = new article();
            $article->setTitle($faker->catchPhrase);
            $article->setContent($faker->text($maxNbChars = 1000));
            $article->setImage('image1.jpg');
            $article->setDate($faker->dateTimeThisYear($max = 'now'));
            $manager->persist($article);
            $manager->flush();

        }
    }
}
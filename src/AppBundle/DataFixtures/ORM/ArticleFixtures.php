<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Article;

class ArticleFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article1 = new article();
        $article1->setTitle('Title1');
        $article1->setContent('Etiam vehicula nunc non leo hendrerit commodo. Vestibulum 
vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur
tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo 
scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum.
Morbi id quam nisl. ');
        $article1->setImage('image1.jpg');
        $article1->setDate(new \DateTime());
        $manager->persist($article1);
        $manager->flush();

    }
}
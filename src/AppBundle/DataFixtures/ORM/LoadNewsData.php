<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Author;
use AppBundle\Entity\News;
use AppBundle\Repository\AuthorRepository;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadNewsData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime();
        $date = $date->setDate(2016,12,10);
        $author = $manager->getRepository('AppBundle:Author');
        $author = $author->findOneBy(array('name' => 'author'));

        $news = new News();
        $news->setTitle('SomeTitle');
        $news->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news->setDate($date);
        $news->setAuthor($author);

        $manager->persist($news);
        $manager->flush();



        $news1 = new News();
        $news1->setTitle('SomeTitle');
        $news1->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news1->setDate($date);
        $news1->setAuthor($author);

        $manager->persist($news1);
        $manager->flush();


        $news2 = new News();
        $news2->setTitle('SomeTitle');
        $news2->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news2->setDate($date);
        $news2->setAuthor($author);

        $manager->persist($news2);
        $manager->flush();



        $news3 = new News();
        $news3->setTitle('SomeTitle');
        $news3->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news3->setDate($date);
        $news3->setAuthor($author);

        $manager->persist($news3);
        $manager->flush();

    }
}
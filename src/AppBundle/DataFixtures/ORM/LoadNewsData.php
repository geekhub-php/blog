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



        $news1 = new News();
        $news1->setTitle('SomeTitle');
        $news1->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news1->setDate($date);
        $news1->setAuthor($author);

        $manager->persist($news1);


        $news2 = new News();
        $news2->setTitle('SomeTitle');
        $news2->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news2->setDate($date);
        $news2->setAuthor($author);

        $manager->persist($news2);



        $news3 = new News();
        $news3->setTitle('SomeTitle');
        $news3->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news3->setDate($date);
        $news3->setAuthor($author);

        $manager->persist($news3);


        $news4 = new News();
        $news4->setTitle('SomeTitle');
        $news4->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news4->setDate($date);
        $news4->setAuthor($author);

        $manager->persist($news4);



        $news5 = new News();
        $news5->setTitle('SomeTitle');
        $news5->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news5->setDate($date);
        $news5->setAuthor($author);

        $manager->persist($news5);


        $news6 = new News();
        $news6->setTitle('SomeTitle');
        $news6->setSubject('SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText
        SomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeTextSomeText');
        $news6->setDate($date);
        $news6->setAuthor($author);

        $manager->persist($news6);

        $manager->flush();

    }
}
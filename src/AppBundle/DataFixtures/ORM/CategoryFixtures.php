<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;
use Faker;

class CategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; ++$i) {
            $faker = Faker\Factory::create();

            $category = new Category();
            $category->setName($faker->unique()->word(2));
            $manager->persist($category);

            $this->addReference("category-{$i}", $category);
        }

        for ($n=$i; $n<=$i+10; $n++) {
            $p=rand(1, 5);
            $category = new Category();
            $category->setName($faker->unique()->word(2));
            $category->setParent($manager->merge($this->getReference("category-{$p}")));

            $this->addReference("category-{$n}", $category);

            $manager->persist($category);
        }

        $manager->flush();
    }



    public function getOrder()
    {
        return 1 ;
    }
}

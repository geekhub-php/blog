<?php

namespace BlogBundle\Entity;

class CategoryEntity
{
    public static function getCategories()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < rand(3, 7); $i++) {
            $hello[$i]['id'] = $i+1;
            $hello[$i]['name'] = $faker->colorName;
            $hello[$i]['count'] = rand(1, 10);
        }
        return $hello;
    }
}

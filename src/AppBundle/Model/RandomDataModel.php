<?php

namespace AppBundle\Model;

use Faker;

/**
 * Class RandomDataModel.
 */
class RandomDataModel
{
    private $faker;

    /**
     * @return Faker\Generator
     */
    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    /**
     * Get random img files names.
     *
     * @param int $quantity
     *
     * @return array
     */
    public function getImages($quantity)
    {
        $images = $this->faker->randomElements($array = array('c-7.jpg', 'c-2.jpg', 'c-3.jpg', 'c-4.jpg', 'c-5.jpg', 'c-6.jpg'), $count = $quantity);

        return $images;
    }

    /**
     * Get random text content.
     *
     * @param int $quantity
     *
     * @return mixed
     */
    public function getDescription($quantity)
    {
        for ($i = 0; $i < $quantity; ++$i) {
            $text[$i] = $this->faker->realText($maxNbChars = 100);
        }

        return $text;
    }
}

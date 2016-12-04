<?php

namespace BlogBundle\Entity;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostEntity
{
    public function getPosts()
    {
        $faker = \Faker\Factory::create();
        for ($i = 1; $i < 6; $i++) {
            $post[$i]['id'] = $i;
            $post[$i]['title'] = $faker->text(6);
            $post[$i]['text'] = $faker->text(200);
            $post[$i]['datetime'] = $faker->date() . ' ' . $faker->time();
        }
        return $post;
    }
    
    public function getPost($id)
    {
        if ($id > 10 || $id < 1) {
            return false;
        }
        $faker = \Faker\Factory::create();
        $post['id'] = $id;
        $post['title'] = $faker->text(6);
        $post['text'] = $faker->text(200);
        $post['datetime'] = $faker->date() . ' ' . $faker->time();
        return $post;
    }
}

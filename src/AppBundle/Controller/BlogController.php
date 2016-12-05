<?php


namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Faker;


class BlogController extends Controller
{
    /**
     * @Route("/article", name="article")
     * @Template()
     */
    public function articleAction()
    {
        $faker = Faker\Factory::create('ru_RU');
        $Article = [];
        for ($i=0;$i<8;$i++)
        {
            $arr = [
                'img' => $faker->imageUrl($width = 640, $height = 480),
                'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'time' => $faker -> time($format = 'H:i:s', $max = 'now'),
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'article' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)

            ];
            array_push($Article, $arr);
        }
        return [
            'Article' => $Article
        ];
    }

    /**
     * @Route("/about", name="about_me")
     * @Template()
     */
    public function aboutAction()
    {
        return $this->render('AppBundle:Blog:about.html.twig');
    }
}
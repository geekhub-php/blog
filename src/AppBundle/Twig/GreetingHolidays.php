<?php
namespace AppBundle\Twig;

/**
 * Created by PhpStorm.
 * User: nima
 * Date: 09.01.17
 * Time: 2:19
 */
class GreetingHolidays extends \Twig_Extension
{
    public function getFunctions()
    {
        $function = function() {
            $result = $this->greetingBuild();
            return $result;
        };
        return array(
            new \Twig_SimpleFunction('greeting', $function),
        );
    }

    public function greetingBuild()
    {

        $today = date("m.d");
        //$result=(strtotime($today)<strtotime("01.14")); //$result === true
        if ($today<="01.30")
        {
            return "<span class='label label-danger spanMeny'>HAPPY NEW YEAR!</span>";
          }
        if ($today="02.24")
        {
            return "<span class='label label-danger spanMeny'>Happy Valentines Day!</span>";
        }
                //return $today;
    }
    public function getName()
    {
        return 'greeting';
    }
}
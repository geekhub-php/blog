<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('app_pagination_render', [$this, 'paginationRender'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
        ];
   }

    /**
     * @param \Twig_Environment $env
     * @param array             $pagination
     *
     * @return mixed|string
     */
    public function paginationRender(\Twig_Environment $env, $pagination)
    {
        return $env->render('AppBundle:default:_pagination.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }
}

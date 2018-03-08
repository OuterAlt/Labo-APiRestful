<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 07/03/2018
 * Time: 22:58
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController extends Controller
{
    /**
     * Homepage
     *
     * @param \Twig\Environment $twig
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function indexAction(
        Environment $twig
    ) {
        return new Response(
            $twig->render("home.html.twig")
        );
    }
}
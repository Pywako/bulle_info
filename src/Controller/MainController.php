<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('Main/homepage.html.twig',[
            'path' => 'homepage'
        ]);
    }
    /**
     * @Route("/mentions", name="mentions")
     */
    public function mentions()
    {
        return $this->render('Main/mentions.html.twig',[
            'path' => 'mentions'
        ]);
    }

}
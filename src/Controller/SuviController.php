<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuviController extends AbstractController
{
    /**
     * @Route("/suvi", name="app_suvi")
     */
    public function index(): Response
    {
        return $this->render('suvi/index.html.twig', [
            'controller_name' => 'SuviController',
        ]);
    }
}

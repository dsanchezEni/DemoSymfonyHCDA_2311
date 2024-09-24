<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }
   /* #[Route('/', name: 'main_home', methods: ['GET'])]
    public function home(): Response
    {
        return new Response("<h1>Accueil</h1>");
    }*/

    #[Route('/test', name: 'main_test', methods: ['GET'])]
    public function test(): Response
    {
        $serie = [
            "title"=>"<h1>Game of Thrones</h1>",
            "year"=>2010
        ];

        /*return new Response("<h1>Test</h1>");*/
        return $this->render('main/test.html.twig',
        [
            "mySerie"=>$serie,
            "autreVar"=>4242
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/cours', name: 'cours_')]
class CourseController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('course/list.html.twig');
    }
    #[Route('/detail/{id}', name: 'show', requirements:['id'=>'\d+'],methods: ['GET'])]
    public function show(int $id): Response{
        return $this->render('course/show.html.twig');
    }

    #[Route('/ajouter', name: 'create', methods: ['GET','POST'])]
    public function create(Request $request): Response{
        dump($request);
        return $this->render('course/create.html.twig');
    }

    #[Route('/modifier/{id}', name: 'edit',requirements:['id'=>'\d+'], methods: ['GET','POST'])]
    public function edit(): Response{
        return $this->render('course/edit.html.twig');
    }
}

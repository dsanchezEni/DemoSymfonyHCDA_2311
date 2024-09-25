<?php

namespace App\Controller;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/demo', name: 'course_demo', methods: ['GET'])]
    public function demo(EntityManagerInterface $em): Response
    {
        //Créer une instance de l'entité
        $course = new Course();
        //hydrater toutes les propriétés.
        $course->setName('Symfony');
        $course->setContent('Le développement web côté serveur (avec Symfony)');
        $course->setDuration(10);
        $course->setDateCreated(new \DateTimeImmutable());
        $course->setPublished(true);

        $em->persist($course);

        dump($course);

        //Penser à flush sinon l'objet n'est pas enregistré dans la BD !
        $em->flush();
        dump($course);

        //On modifie l'objet
        $course->setName('PHP');
        //On n'est pas obligé de faire le persist car doctrine connait déjà l'objet.
        //On sauvegarde l'objet
        $em->flush();
        dump($course);

        //On supprime l'objet
        $em->remove($course);
        $em->flush();
        return $this->render('course/create.html.twig');
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

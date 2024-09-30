<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/cours', name: 'cours_')]
class CourseController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function index(CourseRepository $courseRepository): Response
    {
        //$courses = $courseRepository->findAll();
        //$courses = $courseRepository->findBy([], ['name' => 'DESC'],5);
        $courses = $courseRepository->findLastCourses();
        return $this->render('course/list.html.twig',[
            'courses' => $courses,
        ]);
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
    //public function show(int $id,CourseRepository $courseRepository): Response{
    public function show(Course $course,CourseRepository $courseRepository): Response{
       /* $course = $courseRepository->find($id);
        if(!$course){
            throw $this->createNotFoundException('Cours introuvable');
        }*/
        return $this->render('course/show.html.twig',[
            'course' => $course,
        ]);
    }

    #[Route('/ajouter', name: 'create', methods: ['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response{
        $course=new Course();
        $courseForm = $this->createForm(CourseType::class, $course);
        //traiter le formulaire
        $courseForm->handleRequest($request);
        //Si le formulaire est soumis
        if($courseForm->isSubmitted() && $courseForm->isValid()){
            $em->persist($course);
            $em->flush();
            $this->addFlash('success','Le cours a été ajouté avec succès !');
            return $this->redirectToRoute("cours_show",['id'=>$course->getId()]);
        }

        return $this->render('course/create.html.twig',[
            'courseForm'=>$courseForm,
        ]);
    }

    #[Route('/modifier/{id}', name: 'edit',requirements:['id'=>'\d+'], methods: ['GET','POST'])]
    public function edit(Course $course, Request $request, EntityManagerInterface $em): Response{
        $courseForm = $this->createForm(CourseType::class,$course);
        $courseForm->handleRequest($request);
        if($courseForm->isSubmitted() && $courseForm->isValid()){
            //Le persist n'est pas nécessaire car Doctrine connait déjà l'objet
            $course->setDateModified(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success','Le cours a été modifié !');
            return $this->redirectToRoute("cours_show",['id'=>$course->getId()]);
        }
        return $this->render('course/edit.html.twig',[
            'courseForm'=>$courseForm,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'delete',requirements:['id'=>'\d+'], methods: ['GET'])]
    public function delete(Course $course,Request $request, EntityManagerInterface $em): Response{
        if($this->isCsrfTokenValid('delete'.$course->getId(), $request->get('token'))){
           try{
               $em->remove($course);
               $em->flush();
               $this->addFlash('success','Le cours a été supprimé');
           }catch (\Exception $e){
               $this->addFlash('danger','Le cours n\'a pu être supprimé');
           }
        }else{
            $this->addFlash('danger','Le cours n\'a pu être supprimé: problème de token');
        }
        return $this->redirectToRoute("cours_list");
    }
}

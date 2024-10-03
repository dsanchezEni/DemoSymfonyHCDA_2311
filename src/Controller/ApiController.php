<?php

namespace App\Controller;

use App\Entity\Category;
use App\Models\Region;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/regions', name: 'api_regions',methods: ['GET'])]
    public function regions(SerializerInterface $serializer):Response{
        $content = file_get_contents('https://geo.api.gouv.fr/regions');
       // $regions=$serializer->decode($content,'json');
       // $regionsObjet = $serializer->denormalize($regions,Region::class.'[]');
        $regions = $serializer->deserialize($content,Region::class.'[]','json');
        //dd($regionsObjet);
        //dd($regions);
        return $this->render('api/regions.html.twig',
            ['regions'=>$regions]);

    }
    #[Route('/api/categories', name: 'api_category_list',methods: ['GET'])]
    public function list(CategoryRepository $categoryRepository, SerializerInterface $serializer):JsonResponse{
        $categories = $categoryRepository->findAll();
        //dd($categories);
        //on sérialise les données en Json
       // $resultat = $serializer->serialize($categories, 'json',['groups'=> 'getCategoriesFull']);
        //on retourne une réponse au format JSON
       // return new JsonResponse($resultat, Response::HTTP_OK,[],true);
        return $this->json($categories, Response::HTTP_OK,[],['groups'=>['getCategoriesFull']]);
    }
    #[Route('/api/categories/{id}', name: 'api_category_read',requirements:['id'=>'\d+'],methods: ['GET'])]
    public function read(?Category $category, SerializerInterface $serializer):JsonResponse{
        if(!$category){
            return new JsonResponse(null,Response::HTTP_NOT_FOUND);
        }
        return $this->json($category, Response::HTTP_OK,[],['groups'=>['getCategoriesFull']]);

    }

    #[Route('/api/categories', name: 'api_category_create',methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer,EntityManagerInterface $em):JsonResponse{
       //On crée une category
        //On récupère les données dans la requête.
        $data = $request->getContent();
        $category = $serializer->deserialize($data, Category::class,'json');
        $em->persist($category);
        $em->flush();
        //On retourne une réponse avec le code statut 201 et la nouvelle catégorie au format JSON.
        return $this->json($category, Response::HTTP_CREATED,[
            "Location"=>$this->generateUrl('api_category_read',
                ["id"=>$category->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL)
        ],
            ['groups'=>'getCategoriesFull']
        );
    }

    #[Route('/api/categories/{id}', name: 'api_category_update',requirements:['id'=>'\d+'],methods: ['PUT'])]
    public function update(?Category $category,Request $request,
                           SerializerInterface $serializer,EntityManagerInterface $em):JsonResponse{
        //On test si on a la category
        if(!$category){
            return new JsonResponse(null,Response::HTTP_NOT_FOUND);
        }
        //On récupère les données dans la requête.
        $data = $request->getContent();
        //On injecte les données reçues dans l'objet $category récupéré
        $serializer->deserialize($data,
            Category::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE=>$category]);
        $em->flush();
        //On retourne une réponse avec le code statut 204 sans données.
        return new JsonResponse(null,Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/categories/{id}', name: 'api_category_delete',requirements:['id'=>'\d+'],methods: ['DELETE'])]
    public function delete(?Category $category,EntityManagerInterface $em):JsonResponse{
        //On test si on a la category
        if(!$category){
            return new JsonResponse(null,Response::HTTP_NOT_FOUND);
        }
        $em->remove($category);
        $em->flush();
        //On retourne une réponse avec le code statut 204 sans données.
        return new JsonResponse(null,Response::HTTP_NO_CONTENT);
    }
}












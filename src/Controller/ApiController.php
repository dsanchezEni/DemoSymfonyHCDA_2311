<?php

namespace App\Controller;

use App\Models\Region;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Attribute\Groups;
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
}
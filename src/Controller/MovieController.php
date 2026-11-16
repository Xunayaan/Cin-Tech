<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MovieController extends AbstractController
{
    // #[Route('/movie', name: 'app_movie')]
    // public function index(): Response
    // {
    //     return $this->render('movie/index.html.twig', [
    //         'controller_name' => 'MovieController',
    //     ]);
    // }

    #[Route('/catalogue', name : 'app_movie_index')]
    public function catalogue(Request $request): Response
    {
        $recherche = $request->query->get('recherche','rien');

        return $this->render('movie/index.html.twig', ['controller_name' => 'MovieController', 'recherche' => $recherche]);
    }

    #[Route('/catalogue/{id}', name : 'app_movie_show', requirements:['id' => '\d+'])]
    public function show(int $id): Response
    {
        return $this->render('movie/index.html.twig', ['controller_name' => 'MovieController', 'id' => $id]);
    }

      #[Route('api/catalogue', name : 'app_movie_list')]
    public function list(): JsonResponse
    {
        return $this->json([
            'movies' => [
                ['id' => 1, 'title' => 'Inception', 'year' => 2010],
                ['id' => 2, 'title' => 'The Matrix', 'year' => 1999],
                ['id' => 3, 'title' => 'Interstellar', 'year' => 2014],
            ],
        ]);
    }
}

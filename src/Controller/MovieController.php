<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MovieRepository;

final class MovieController extends AbstractController
{
    private array $movies = [
        ['id' => 1, 'title' => 'Film1', 'year' => 2010, 'category' => 'Action', 'synopsis' => 'Synopsis du film 1' , 'rating' => 4.5],
        ['id' => 2, 'title' => 'Film2', 'year' => 1999, 'category' => 'Comedy', 'synopsis' => 'Synopsis du film 2', 'rating' => 4.0],
        ['id' => 3, 'title' => 'Film3', 'year' => 2014, 'category' => 'Drama', 'synopsis' => 'Synopsis du film 3', 'rating' => 4.2],
    ];

    // #[Route('/movie', name: 'app_movie')]
    // public function index(): Response
    // {
    //     return $this->render('movie/index.html.twig', [
    //         'controller_name' => 'MovieController',
    //     ]);
    // }

    // #[Route('/catalogue', name : 'app_movie_index')]
    // public function catalogue(Request $request): Response
    // {
    //     $recherche = $request->query->get('recherche','rien');

    //     return $this->render('movie/index.html.twig', ['controller_name' => 'MovieController', 'recherche' => $recherche, 'movies' => $this->movies]);
    // }

    //   #[Route('api/catalogue', name : 'app_movie_list')]
    // public function list(): JsonResponse
    // {
    //     return $this->json([
    //         'movies' => [
    //             ['id' => 1, 'title' => 'Inception', 'year' => 2010],
    //             ['id' => 2, 'title' => 'The Matrix', 'year' => 1999],
    //             ['id' => 3, 'title' => 'Interstellar', 'year' => 2014],
    //         ],
    //     ]);
    // }

    // #[Route('/catalogue/{id}', name : 'app_movie_show', requirements:['id' => '\d+'])]
    // public function show(int $id) : Response{
    //     foreach ($this->movies as $m){
    //         if ($m['id'] === $id){
    //             return $this->render('movie/show.html.twig', ['movie' => $m ]);
    //             break;
    //         }
            
    //     }
    //      throw $this->createNotFoundException('Film introuvable');
        
    // }

    #[Route('/catalogue', name : 'app_movie_list')]
    public function index(MovieRepository $MovieRepository): Response
    {
        $movies = $MovieRepository->findAllWithCategory();
        return $this->render('movie/index.html.twig', ['movies' => $movies]);
    }
}

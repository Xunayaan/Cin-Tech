<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MovieRepository;
use App\Entity\Movie;
use App\Form\MovieType;

final class MovieController extends AbstractController
{

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

    #[Route('/catalogue/{id}', name : 'app_movie_show', requirements:['id' => '\d+'])]
    public function show(MovieRepository $MovieRepository, int $id) : Response{
        $movie = $MovieRepository->find($id);
        if (!$movie) {
            throw $this->createNotFoundException('Film introuvable');
        }
        return $this->render('movie/show.html.twig', ['movie' => $movie ]);

    }

    #[Route('/catalogue', name : 'app_movie_list', methods: ['GET','POST'])]
    public function index(MovieRepository $MovieRepository): Response
    {
        $movies = $MovieRepository->findAllWithCategory();
        return $this->render('movie/index.html.twig', ['movies' => $movies]);
    }

    #[Route('/catalogue/form', name : 'app_movie_form')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer le film en base de données
            $em->persist($movie);
            $em->flush();

            // Rediriger vers la liste des films après l'enregistrement
            $this->addFlash('success', 'Le film a été ajouté avec succès !');
            return $this->redirectToRoute('app_movie_list');
        }

        return $this->render('movie/form.html.twig',['form' => $form]);
    }

    #[Route('/catalogue/{id}/edit', name : 'app_movie_edit', requirements:['id' => '\d+'], methods: ['GET','POST'])]
    public function edit(Movie $movie, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this ->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }

        $this->addFlash('succes','Le film à été modifié');
        return $this->render('movie/form.html.twig' , ['form' => $form]);
    }

    #[Route('/catalogue/{id}', name : 'app_movie_delete', requirements:['id' => '\d+'], methods: ['POST'])]
    public function delete(Movie $movie, Request $request, EntityManagerInterface $em) : Response 
    {
        $token = $request->getPayload()->getString('_token');

        if($this->isCsrfTokenValid('delete'.$movie->getId(), $token)){
            $em->remove($movie);
            $em->flush();
            $this->addFlash('success', 'Le film à été supprimé');
            
        }
        return $this->redirectToRoute('app_movie_list');
    }
}
 
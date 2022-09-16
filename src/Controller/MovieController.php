<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MovieService;

class MovieController extends AbstractController
{
    /**
     * @Route(
     *     path = "/movies",
     *     name="movies"
     * )
     *
     * @return Response
     */
    public function moviesAction(Request $request, MovieService $movieService): Response
    {
        return new Response($this->renderView(
            'movies/index.html.twig',
            [
                'genres' => $movieService->getGenres(),
                'movies' => $movieService->getMovies(),
                'bestMovie' => $movieService->getMostPopular()
            ]
        ));
    }
    /**
     * @Route(
     *     path = "/movies/search",
     *     name="searchMovies"
     * )
     *
     * @return Response
     */
    public function searchAction(Request $request, MovieService $movieService) {
        if ($request->isXmlHttpRequest()) {
            $data = $request->toArray(); 
            $movies = $movieService->searchMovies($data['query']);
            return $this->render('movies/movies.html.twig', [
                'movies' => $movies['movies'],
                'bestMovie' => $movies['bestMovie']
            ]);
        }
    }
    /**
     * @Route(
     *     path = "/movies/genre/{genreId}",
     *     name="moviesByGenre",
     *     requirements={
     *          "genreId"="\d+"
     *     }
     * )
     *
     * @return Response
     */
    public function moviesByGenreAction(Request $request, MovieService $movieService, int $genreId) {
        if ($request->isXmlHttpRequest()) {
            $popularMovieData = $movieService->getMoviesByGenre($genreId);
            return $this->render('movies/movies.html.twig', [                
                'movies' => $popularMovieData['movies'],
                'bestMovie' => $popularMovieData['bestMovie']
            ]);
        }
    }
}

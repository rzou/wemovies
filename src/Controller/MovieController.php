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
    public function movies(Request $request, MovieService $movieService): Response
    {
        //$client = $this->movieRepository->get('/3/movie/550', []);
        // return new Response($this->renderView(
        //     'movies.html.twig'
        // ));
        $movie = $movieService->getMovie(5);
        var_dump($movie);
        exit;
    }

}

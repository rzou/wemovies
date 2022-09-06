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
        $result = $movieService->getMovies();
        return new Response($this->renderView(
            'movies.html.twig',
            [
                'genres' => $result['genres'],
                'movies' => $result['movies'],
            ]
        ));
    }

}

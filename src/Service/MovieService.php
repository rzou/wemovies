<?php

namespace App\Service;

use App\Repository\BaseRepository;

class MovieService 
{
    Const GET_MOVIE_BY_ID = '/movie/{movie_id}';

    /** BaseRepository */
    private $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getMovie($id)
    {
        $uri = str_replace('{movie_id}', $id, self::GET_MOVIE_BY_ID);
        $data = $this->repository->get($uri);
        return $data->getContent();
    }
}
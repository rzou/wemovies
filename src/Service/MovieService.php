<?php

namespace App\Service;

use App\Repository\BaseRepository;

class MovieService 
{
    const GET_GENRES = '/genre/movie/list';
    const GET_MOVIE_BY_ID = '/movie/{movie_id}';
    const GET_MOVIES = '/discover/movie?sort_by=popularity.desc';

    /** BaseRepository */
    private $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getMovie($id)
    {
        $uri = str_replace('{movie_id}', $id, self::GET_MOVIE_BY_ID);
        $movie = $this->repository->get($uri);
        return $movie->toArray();
    }

    public function getMovies()
    {
        $result = [];
        $list = [];
        $uri = self::GET_GENRES;
        $data = $this->repository->get($uri);
        $genres = $data->toArray()['genres'];
        $result['genres'] = $genres;
        $genres = array_map(function($genre){
            return $genre['id'];
        }, $genres);
        foreach($genres as $genre) {
            $list[$genre] = [];
        }
        $uri = self::GET_MOVIES;
        $data = $this->repository->get($uri);
        $movies = $data->toArray()['results'];
        $movies = array_map(function($movie){
            foreach($movie['genre_ids'] as $id){
                $list[$id][] = $movie;
            }
        }, $movies);
        $result['movies'] = $list;
        return $result;
    }
}
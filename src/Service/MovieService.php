<?php

namespace App\Service;

use App\Repository\BaseRepository;

class MovieService 
{
    const GET_GENRES = '/genre/movie/list';
    const GET_MOVIES = '/discover/movie?sort_by=vote_average.desc';
    const GET_MOST_POPULAR = '/movie/popular?language=fr-FR&page=1';
    const GET_MOVIE_VIDEOS = '/movie/{movie_id}/videos';
    const SEARCH_MOVIES = '/search/movie?query={query}';
    const GET_MOVIES_BY_GENRE = '/discover/movie?sort_by=popularity.desc&include_adult=false&include_video=true&language=fr-FR&page=1&with_genres={genreId}';
    const GET_CONFIGURATION = '/configuration';
    const BASE_URL = [
        'YouTube' => 'https://www.youtube.com/embed/',
        'Vimeo' => 'https://www.vimeo.com/embed/'
    ];
    /** BaseRepository */
    private $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getConfiguration()
    {
        $uri = self::GET_CONFIGURATION;
        $configuration = $this->repository->get($uri);
        $configuration = $configuration->toArray();
        return [
            'base_url' => $configuration['images']['secure_base_url'],
            'size' => $configuration['images']['logo_sizes'][5]
        ];
    }
    public function getMostPopular()
    {
        $uri = self::GET_MOST_POPULAR;
        $movie = $this->repository->get($uri);
        $movieDetails = $movie->toArray()['results'][0];
        $result = array(
            "title" => $movieDetails['title'],
            "overview" => $movieDetails['overview'],
            "video_url" => $this->getMovieVideo($movieDetails['id']),
        );
        return $result;
    }
    public function getMovieVideo($id)
    {
        $uri = str_replace('{movie_id}', $id, self::GET_MOVIE_VIDEOS);
        $movie = $this->repository->get($uri);
        //var_dump($movie->toArray());exit;
        $video = $movie->toArray()['results'];
        if(!empty($video)) {
            $video = $video[0];
            return self::BASE_URL[$video['site']] . $video['key'];
        } else {
            return '';
        }
        
    }
    public function getGenres() {
        $uri = self::GET_GENRES;
        $data = $this->repository->get($uri);
        return $data->toArray()['genres'];
    }
    public function getMovies()
    {
        $uri = self::GET_MOVIES;
        $data = $this->repository->get($uri);
        $movies = $data->toArray()['results'];
        return $this->transformMovie($movies);
    }

    public function searchMovies($query)
    {
        $uri = str_replace('{query}', $query, self::SEARCH_MOVIES);
        $data = $this->repository->get($uri);
        $movies = $data->toArray()['results'];
        $movie = $movies[0];
        return [
            'bestMovie' => array(
                "title" => $movie['title'],
                "overview" => $movie['overview'],
                "video_url" => $this->getMovieVideo($movie['id']),
            ),
            'movies' => $this->transformMovie($movies)
        ];
    }

    public function getMoviesByGenre($genreId)
    {
        $uri = str_replace('{genreId}', $genreId, self::GET_MOVIES_BY_GENRE);
        $data = $this->repository->get($uri);
        $movies = $data->toArray()['results'];
        $movie = $movies[0];
        return [
            'bestMovie' => array(
                "title" => $movie['title'],
                "overview" => $movie['overview'],
                "video_url" => $this->getMovieVideo($movie['id']),
            ),
            'movies' => $this->transformMovie($movies)
        ];
    }

    public function transformMovie($movies) {
        $result = [];
        $configuration = $this->getConfiguration();
        $base_url = $configuration['base_url'] . $configuration['size'];
        foreach($movies as $movie){
            $result[] = [
                'title' => $movie['title'],
                'overview' => $movie['overview'],
                'poster_path' => $base_url . $movie['poster_path'],
            ];
        }
        return $result;
    }
}
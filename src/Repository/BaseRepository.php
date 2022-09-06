<?php 

namespace App\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class BaseRepository 
{

    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function get(string $uri): ResponseInterface
    {
        return $this->client->request('GET', '/3/'.$uri);
    }

}
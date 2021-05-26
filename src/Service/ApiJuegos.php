<?php
// src/Service/MessageGenerator.php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiJuegos
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getJuegos($pagina): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.rawg.io/api/games?key=f10de120cd344ca996eed2acff8560dc&page='.$pagina
        );

        if($response->getStatusCode() == 200){
            $listaJuegos = $response->getContent();
        }else{
            $listaJuegos = "";
        }

        return json_decode($listaJuegos, true)['results'];
    }

    public function getJuego($id): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.rawg.io/api/games/'.$id.'?key=f10de120cd344ca996eed2acff8560dc'
        );

        if($response->getStatusCode() == 200){
            $juego = $response->getContent();
        }else{
            $juego = "";
        }

        return json_decode($juego, true);
    }
}


<?php

namespace ApiClient\Example;

use ApiClient\Example\Pokedex\Service\PokedexService;
use Exception;

require __DIR__ . '/../vendor/autoload.php';

$pokedex = new PokedexService();

try {
    $result = $pokedex->getPokemon("pikachu");
    var_dump($result);

    $result = $pokedex->getItem("master-ball");
    var_dump($result);

    $result = $pokedex->getMove("pound");
    var_dump($result);
} catch (Exception $e) {
    var_dump($e->getMessage());
}
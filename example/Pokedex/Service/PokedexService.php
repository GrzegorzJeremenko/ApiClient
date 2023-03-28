<?php

namespace ApiClient\Example\Pokedex\Service;

use ApiClient\ApiClient;
use ApiClient\Authorization\Strategy\JWTAuthorizationStrategy;
use ApiClient\CurlConnect;
use ApiClient\Logger;
use ApiClient\Signer;
use Exception;
use Slim\Psr7\Factory\RequestFactory;

class PokedexService
{
    private ApiClient $apiClient;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $logger = new Logger([
            "logTo" => [
                "Console",
                "File"
            ],
            "logDir" => __DIR__ . "/../../../logs/"
        ]);

        $signer = new Signer();
        $signer->setMethod(new JWTAuthorizationStrategy());
        $signer->setKey("testKey");

        $curlConnect = new CurlConnect();

        $this->apiClient = new ApiClient();
        $this->apiClient->setLogger($logger);
        $this->apiClient->setSigner($signer);
        $this->apiClient->setConnect($curlConnect);
    }

    /**
     * @throws Exception
     */
    public function getPokemon(string $name): mixed
    {
        $requestFactory = new RequestFactory();
        $request = $requestFactory->createRequest(
            "GET",
            sprintf(
                "https://pokeapi.co/api/v2/pokemon/%s",
                $name
            )
        );
        $request = $request->withHeader("User-Agent", "Mozilla/5.0");

        $response = $this->apiClient->sendRequest($request);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @throws Exception
     */
    public function getItem(string $name): mixed
    {
        $requestFactory = new RequestFactory();
        $request = $requestFactory->createRequest(
            "GET",
            sprintf(
                "https://pokeapi.co/api/v2/item/%s",
                $name
            )
        );
        $request = $request->withHeader("User-Agent", "Mozilla/5.0");

        $response = $this->apiClient->sendRequest($request);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @throws Exception
     */
    public function getMove(string $name): mixed
    {
        $requestFactory = new RequestFactory();
        $request = $requestFactory->createRequest(
            "GET",
            sprintf(
                "https://pokeapi.co/api/v2/move/%s",
                $name
            )
        );
        $request = $request->withHeader("User-Agent", "Mozilla/5.0");

        $response = $this->apiClient->sendRequest($request);

        return json_decode($response->getBody()->getContents());
    }
}
<?php

namespace ApiClient;

use ApiClient\Connect\Interface\ConnectInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ResponseFactory;

class CurlConnect implements ConnectInterface
{
    public function connect(RequestInterface $request): ResponseInterface
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request->getUri());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->convertToAssociativeArray($request->getHeaders()));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($request->getBody()));
        $responseBody = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $this->generateResponse($responseBody, $statusCode);
    }

    private function generateResponse(string $responseBody, int $statusCode): ResponseInterface
    {
        $responseFactory = new ResponseFactory();
        $response = $responseFactory->createResponse($statusCode);
        $response->getBody()->write($responseBody);

        return $response;
    }

    private function convertToAssociativeArray(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $result[$key] = $value[0];
        }

        return $result;
    }
}
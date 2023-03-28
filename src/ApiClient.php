<?php

namespace ApiClient;

use ApiClient\Connect\Interface\ConnectInterface;
use ApiClient\Exception\ApiClientException;
use Exception;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class ApiClient implements ClientInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var Signer
     */
    private Signer $signer;

    /**
     * @var ConnectInterface
     */
    private ConnectInterface $connect;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->setLogger(new Logger([]));
        $this->setConnect(new CurlConnect());
    }

    /**
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param Signer $signer
     * @return void
     */
    public function setSigner(Signer $signer): void
    {
        $this->signer = $signer;
    }

    /**
     * @param ConnectInterface $connect
     * @return void
     */
    public function setConnect(ConnectInterface $connect): void
    {
        $this->connect = $connect;
    }

    /**
     * @throws Exception
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            $this->logger->info(
                sprintf(
                    "Request: %s %s",
                    $request->getMethod(),
                    $request->getUri()
                )
            );

            $response = $this->makeRequest($request);

            $this->logger->info(
                sprintf(
                    "Response: %s Status: %s Body: %s",
                    $request->getUri(),
                    $response->getStatusCode(),
                    $response->getBody()
                )
            );

            $response->getBody()->rewind();
            return $response;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ApiClientException
     */
    private function makeRequest(RequestInterface $request): ResponseInterface
    {
        if (isset($this->signer) === true) {
            $request = $this->signer->sign($request);
        }

        if (isset($this->connect) === false) {
            throw new ApiClientException("No connection set!");
        }

        return $this->connect->connect($request);
    }
}
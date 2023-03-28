<?php

namespace ApiClient\Tests;

use ApiClient\ApiClient;
use ApiClient\Authorization\Strategy\BasicAuthorizationStrategy;
use ApiClient\Authorization\Strategy\JWTAuthorizationStrategy;
use ApiClient\Signer;
use Exception;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\RequestFactory;

class ApiClientTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGet()
    {
        $requestFactory = new RequestFactory();

        $request = $requestFactory->createRequest('GET', 'https://www.google.com/');
        $request = $request->withHeader('User-Agent', 'Mozilla/5.0');

        $client = new ApiClient();

        $response = $client->sendRequest($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testWithInvalidUrl()
    {
        $requestFactory = new RequestFactory();

        $request = $requestFactory->createRequest('GET', 'https://www.google.com/invalid');
        $request = $request->withHeader('User-Agent', 'Mozilla/5.0');

        $client = new ApiClient();

        $response = $client->sendRequest($request);

        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testWithBasicAuthorization()
    {
        $requestFactory = new RequestFactory();

        $request = $requestFactory->createRequest('GET', 'http://httpbin.org/bearer');
        $request = $request->withHeader('User-Agent', 'Mozilla/5.0');

        $signer = new Signer();
        $signer->setMethod(new BasicAuthorizationStrategy());
        $signer->setKey("test");

        $client = new ApiClient();
        $client->setSigner($signer);

        $response = $client->sendRequest($request);

        $this->assertEquals(401, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testWithJWTAuthorization()
    {
        $requestFactory = new RequestFactory();

        $request = $requestFactory->createRequest('GET', 'https://www.google.com/');
        $request = $request->withHeader('User-Agent', 'Mozilla/5.0');

        $signer = new Signer();
        $signer->setMethod(new JWTAuthorizationStrategy());
        $signer->setKey("testKey");

        $client = new ApiClient();
        $client->setSigner($signer);

        $response = $client->sendRequest($request);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
<?php

namespace ApiClient\Tests;

use ApiClient\CurlConnect;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\RequestFactory;

class CurlConnectTest extends TestCase
{
    public function testCurlConnect()
    {
        $requestFactory = new RequestFactory();

        $request = $requestFactory->createRequest('GET', 'http://www.google.com');
        $request = $request->withHeader('User-Agent', 'Mozilla/5.0');

        $curlConnect = new CurlConnect();
        $response = $curlConnect->connect($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCurlInvalidConnect()
    {
        $requestFactory = new RequestFactory();

        $request = $requestFactory->createRequest('GET', 'http://www.google.com/invalid');
        $request = $request->withHeader('User-Agent', 'Mozilla/5.0');

        $curlConnect = new CurlConnect();
        $response = $curlConnect->connect($request);

        $this->assertEquals(404, $response->getStatusCode());
    }
}
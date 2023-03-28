<?php

namespace ApiClient\Tests;

use ApiClient\Authorization\Strategy\BasicAuthorizationStrategy;
use ApiClient\Authorization\Strategy\JWTAuthorizationStrategy;
use ApiClient\Signer;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\RequestFactory;

class SignerTest extends TestCase
{
    public function testSignerWithBasicAuth()
    {
        $requestFactory = new RequestFactory();
        $signer = new Signer();

        $signer->setMethod(new BasicAuthorizationStrategy());
        $signer->setKey("test");

        $request = $requestFactory->createRequest('GET', 'http://httpbin.org/bearer');
        $request = $signer->sign($request);

        $this->assertEquals("Basic test", $request->getHeader("Authorization")[0]);
    }

    public function testSignerWithJWTAuth()
    {
        $requestFactory = new RequestFactory();
        $signer = new Signer();

        $signer->setMethod(new JWTAuthorizationStrategy());
        $signer->setKey("test");

        $request = $requestFactory->createRequest('GET', 'http://httpbin.org/bearer');
        $request = $signer->sign($request);

        $this->assertEquals("Bearer test", $request->getHeader("Authorization")[0]);
    }
}
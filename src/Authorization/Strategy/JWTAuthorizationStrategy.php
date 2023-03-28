<?php

namespace ApiClient\Authorization\Strategy;

use ApiClient\Authorization\Interface\AuthorizationInterface;
use Psr\Http\Message\RequestInterface;

class JWTAuthorizationStrategy implements AuthorizationInterface
{
    /**
     * @param RequestInterface $request
     * @param string $key
     * @return RequestInterface
     */
    public function authorize(RequestInterface $request, string $key): RequestInterface
    {
        return $request->withHeader('Authorization', sprintf('Bearer %s', $key));
    }
}
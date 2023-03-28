<?php

namespace ApiClient\Authorization\Interface;

use Psr\Http\Message\RequestInterface;

interface AuthorizationInterface
{
    /**
     * @param RequestInterface $request
     * @param string $key
     * @return RequestInterface
     */
    public function authorize(RequestInterface $request, string $key): RequestInterface;
}
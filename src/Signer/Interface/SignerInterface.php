<?php

namespace ApiClient\Signer\Interface;

use ApiClient\Authorization\Interface\AuthorizationInterface;
use Psr\Http\Message\RequestInterface;

interface SignerInterface
{
    /**
     * @param AuthorizationInterface $method
     * @return void
     */
    public function setMethod(AuthorizationInterface $method): void;

    /**
     * @param string $key
     * @return void
     */
    public function setKey(string $key): void;

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function sign(RequestInterface $request): RequestInterface;
}
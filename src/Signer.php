<?php

namespace ApiClient;

use ApiClient\Authorization\Interface\AuthorizationInterface;
use ApiClient\Signer\Interface\SignerInterface;
use Psr\Http\Message\RequestInterface;

class Signer implements SignerInterface
{
    /**
     * @var AuthorizationInterface
     */
    private AuthorizationInterface $method;

    /**
     * @var string
     */
    private string $key;

    /**
     * @param AuthorizationInterface $method
     * @return void
     */
    public function setMethod(AuthorizationInterface $method): void
    {
        $this->method = $method;
    }

    /**
     * @param string $key
     * @return void
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function sign(RequestInterface $request): RequestInterface
    {
        return $this->method->authorize($request, $this->key);
    }
}
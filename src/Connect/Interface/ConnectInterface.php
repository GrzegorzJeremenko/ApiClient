<?php

namespace ApiClient\Connect\Interface;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ConnectInterface
{
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function connect(RequestInterface $request): ResponseInterface;
}
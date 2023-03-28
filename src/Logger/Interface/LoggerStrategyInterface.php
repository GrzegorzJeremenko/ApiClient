<?php

namespace ApiClient\Logger\Interface;

interface LoggerStrategyInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function push(string $message): void;
}
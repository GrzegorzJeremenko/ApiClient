<?php

namespace ApiClient\Logger\Strategy;

use ApiClient\Logger\Interface\LoggerStrategyInterface;

class ConsoleLoggerStrategy implements LoggerStrategyInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function push(string $message): void
    {
        echo sprintf(
            "%s\r\n",
            $message
        );
    }
}
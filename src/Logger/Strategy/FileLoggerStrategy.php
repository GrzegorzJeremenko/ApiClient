<?php

namespace ApiClient\Logger\Strategy;

use ApiClient\Logger\Interface\LoggerStrategyInterface;
use Psr\Log\InvalidArgumentException;

class FileLoggerStrategy implements LoggerStrategyInterface
{
    /**
     * @param array $config
     */
    public function __construct(
        private readonly array $config
    ) {
        $this->createDir();
    }

    /**
     * @param string $message
     * @return void
     */
    public function push(string $message): void
    {
        file_put_contents(
            sprintf(
                "%s/%s.log",
                $this->config['logDir'],
                (new \DateTime())->format('Y-m-d')
            ),
            $message . "\n",
            FILE_APPEND
        );
    }

    /**
     * @return void
     */
    private function createDir(): void
    {
        if (file_exists($this->config['logDir']) === FALSE) {
            if (mkdir($this->config['logDir'], 0777, true) === FALSE) {
                throw new InvalidArgumentException(
                    sprintf(
                        "Cannot create logs dir in %s",
                        $this->config['logDir']
                    )
                );
            }
        }
    }
}
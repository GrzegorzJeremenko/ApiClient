<?php

namespace ApiClient;

use ApiClient\Logger\Interface\LoggerStrategyInterface;
use Exception;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{

    /**
     * @var array
     */
    private array $strategy = [];

    /**
     * @throws Exception
     */
    public function __construct(
        private readonly array $config
    ) {
        $strategies = $this->config['logTo'] ?? null;
        $this->loadStrategies($strategies);
    }

    /**
     * @param array|null $strategies
     * @return void
     */
    private function loadStrategies(?array $strategies): void
    {
        foreach ($strategies ?? [] as $strategy) {
            $strategyService = sprintf(
                "ApiClient\Logger\Strategy\%sLoggerStrategy",
                ucfirst($strategy)
            );
            $this->addStrategy(new $strategyService($this->config));
        }
    }

    /**
     * @param LoggerStrategyInterface $strategy
     * @return void
     */
    public function addStrategy(LoggerStrategyInterface $strategy): void
    {
        $this->strategy[] = $strategy;
    }

    /**
     * @param $level
     * @param string|\Stringable $message
     * @param array $context
     * @return void
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $this->push($this->prepareMessage($level, $message));
    }

    /**
     * @param string $level
     * @param string $message
     * @return string
     */
    private function prepareMessage(string $level, string $message): string
    {
        return sprintf(
            "[%s][ApiClient][%s] %s",
            (new \DateTime("now"))->format("Y-m-d H:i:s"),
            strtoupper($level),
            $message
        );
    }

    /**
     * @param string $message
     * @return void
     */
    private function push(string $message): void
    {
        foreach ($this->strategy as $strategy) {
            $strategy->push($message);
        }
    }
}
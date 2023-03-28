<?php

namespace ApiClient\Tests;

use ApiClient\Logger;
use ApiClient\Logger\Strategy\ConsoleLoggerStrategy;
use Exception;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;

class LoggerTest extends TestCase
{
    private $root;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('exampleDir');
    }

    /**
     * @throws Exception
     */
    public function testLoggerConsoleLog()
    {
        $logger = new Logger([
            'logTo' => [
                'console'
            ]
        ]);

        $logger->log(LogLevel::INFO, "test");

        $this->expectOutputRegex('/test/');
    }

    public function testLoggerFileLog()
    {
        $logger = new Logger([
            'logTo' => [
                'file'
            ],
            'logDir' => vfsStream::url('exampleDir/')
        ]);

        $this->assertFalse($this->root->hasChild(sprintf(
            "%s.log",
            (new \DateTime())->format('Y-m-d')
        )));
        $logger->log(LogLevel::INFO, "test");
        $this->assertTrue($this->root->hasChild(sprintf(
            "%s.log",
            (new \DateTime())->format('Y-m-d')
        )));
    }
}
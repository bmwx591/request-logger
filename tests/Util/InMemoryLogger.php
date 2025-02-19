<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Tests\Util;

use Psr\Log\LoggerInterface;

class InMemoryLogger implements LoggerInterface
{
    private array $logs = [];

    public function emergency($message, array $context = [])
    {
        // TODO: Implement emergency() method.
    }

    public function alert($message, array $context = [])
    {
        // TODO: Implement alert() method.
    }

    public function critical($message, array $context = [])
    {
        // TODO: Implement critical() method.
    }

    public function error($message, array $context = [])
    {
        // TODO: Implement error() method.
    }

    public function warning($message, array $context = [])
    {
        // TODO: Implement warning() method.
    }

    public function notice($message, array $context = [])
    {
        // TODO: Implement notice() method.
    }

    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }

    public function debug($message, array $context = [])
    {
        // TODO: Implement debug() method.
    }

    public function log($level, $message, array $context = [])
    {
        if (!isset($this->logs[$level])) {
            $this->logs[$level] = [];
        }

        $this->logs[$level][] = [$message, $context];
    }

    public function getLogs(): array
    {
        return $this->logs;
    }
}

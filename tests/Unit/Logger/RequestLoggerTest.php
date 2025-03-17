<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Tests\Unit\Logger;

use Bmwx591\RequestLogger\Logger\RequestInfo;
use Bmwx591\RequestLogger\Logger\RequestLogger;
use Bmwx591\RequestLogger\Mapper\RequestMapperInterface;
use Bmwx591\RequestLogger\Request\WrappedRequest;
use Bmwx591\RequestLogger\Response\WrappedResponse;
use Bmwx591\RequestLogger\RulesResolver\RulesResolverInterface;
use Bmwx591\RequestLogger\Tests\Util\InMemoryLogger;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class RequestLoggerTest extends TestCase
{
    private LoggerInterface $logger;

    private RequestMapperInterface $requestMapper;

    private int $externalsCount;

    private RulesResolverInterface $rulesResolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger         = new InMemoryLogger();
        $this->externalsCount = 0;
        $this->rulesResolver  = $this->createStub(RulesResolverInterface::class);
        $this->requestMapper  = $this->createStub(RequestMapperInterface::class);
        $this->requestMapper->method('mapLogTitle')->willReturn('main');
        $this->requestMapper->method('mapExternalLogTitle')->willReturn('external');
    }

    public function testLogAllIfRulesResolverNotProvided(): void
    {
        $this->initializeRequestLogger()->pushLogs();

        $logs = $this->logger->getLogs()['info'];
        self::assertCount(2, $logs);

        $main = $logs[0];
        self::assertEquals('main', $main[0]);

        $this->assertExternalRequestsCount(1, $logs);
    }

    public function testLogOnlyMainRequest(): void
    {
        $this->rulesResolver->method('needToLogMainRequest')->willReturn(true);
        $this->rulesResolver->method('needToLogExternalRequests')->willReturn(false);

        $this->initializeRequestLogger($this->rulesResolver)->pushLogs();

        $logs = $this->logger->getLogs()['info'];
        self::assertCount(1, $logs);
        $main = $logs[0];
        self::assertEquals('main', $main[0]);
        $this->assertExternalRequestsCount(0, $logs);
    }

    public function testLogOnlyExternalRequests(): void
    {
        $this->rulesResolver->method('needToLogExternalRequests')->willReturn(true);
        $this->rulesResolver->method('needToLogExternalRequest')->willReturn(true);

        $this->initializeRequestLogger($this->rulesResolver)->pushLogs();

        $logs = $this->logger->getLogs()['info'];
        self::assertCount(1, $logs);
        $this->assertExternalRequestsCount(1, $logs);
    }

    public function testLogOnlySomeExternalRequests(): void
    {
        $this->rulesResolver->method('needToLogExternalRequests')->willReturn(true);
        $this->rulesResolver->method('needToLogExternalRequest')->will(
            $this->onConsecutiveCalls(true, false),
        );

        $this->initializeRequestLogger($this->rulesResolver)
             ->addExternal(new RequestInfo($this->stubWrappedRequest(), $this->stubWrappedResponse()))
             ->pushLogs();

        $logs = $this->logger->getLogs()['info'];
        self::assertCount(1, $logs);
        $this->assertExternalRequestsCount(1, $logs);
    }

    private function initializeRequestLogger(?RulesResolverInterface $rulesResolver = null): RequestLogger
    {
        $requestLogger = new RequestLogger(
            $this->logger,
            $this->requestMapper,
            $rulesResolver,
        );

        return $requestLogger
            ->incomingRequest($this->stubWrappedRequest())
            ->outgoingResponse($this->stubWrappedResponse())
            ->addExternal(new RequestInfo($this->stubWrappedRequest(), $this->stubWrappedResponse()));
    }

    private function stubWrappedRequest(): WrappedRequest
    {
        $stub = $this->createStub(WrappedRequest::class);
        $stub->method('originalRequest')->willReturn($this->createStub(RequestInterface::class));

        return $stub;
    }

    private function stubWrappedResponse(): WrappedResponse
    {
        $stub = $this->createStub(WrappedResponse::class);
        $stub->method('originalResponse')->willReturn($this->createStub(ResponseInterface::class));

        return $stub;
    }

    private function increaseExternalsCounter(): void
    {
        ++$this->externalsCount;
    }

    private function assertExternalRequestsCount(int $expected, array $logs): void
    {
        foreach ($logs as $log) {
            [$message, $_] = $log;

            if ($message === 'external') {
                $this->increaseExternalsCounter();
            }
        }

        self::assertEquals($expected, $this->externalsCount);
    }
}

<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Logger;

use Bmwx591\RequestLogger\Mapper\RequestMapperInterface;
use Bmwx591\RequestLogger\Request\WrappedRequest;
use Bmwx591\RequestLogger\Response\WrappedResponse;
use Bmwx591\RequestLogger\RulesResolver\RulesResolverInterface;
use DateTimeImmutable;
use DateTimeInterface;
use Psr\Log\LoggerInterface;

class RequestLogger
{
    private LoggerInterface $logger;

    private RequestMapperInterface $requestMapper;

    private ?RulesResolverInterface $rulesResolver;

    private ?WrappedRequest $incomingRequest = null;

    private ?WrappedResponse $outgoingResponse = null;

    private ?DateTimeInterface $requestDate = null;

    /** @var array<RequestInfo> */
    private array $externals = [];

    public function __construct(
        LoggerInterface         $logger,
        RequestMapperInterface  $requestMapper,
        ?RulesResolverInterface $rulesResolver = null
    ) {
        $this->logger        = $logger;
        $this->requestMapper = $requestMapper;
        $this->rulesResolver = $rulesResolver;
    }

    public function incomingRequest(WrappedRequest $request): self
    {
        $this->incomingRequest = $request;
        $this->requestDate     = new DateTimeImmutable();

        return $this;
    }

    public function outgoingResponse(WrappedResponse $response): self
    {
        $this->outgoingResponse = $response;

        return $this;
    }

    public function addExternal(RequestInfo $external): self
    {
        $this->externals[] = $external;

        return $this;
    }

    public function pushLogs(): void
    {
        $incomingRequest = new RequestInfo(
            $this->incomingRequest,
            $this->outgoingResponse,
            $this->requestDate,
        );

        if ($this->needToLogMainRequest($incomingRequest)) {
            $this->logger->info(
                $this->requestMapper->mapLogTitle($incomingRequest),
                $this->requestMapper->mapLogContext($incomingRequest),
            );
        }

        if ($this->needToLogExternalRequests($incomingRequest)) {
            $this->pushExternalsLog();
        }
    }

    private function pushExternalsLog(): void
    {
        foreach ($this->externals as $external) {
            if ($this->needToLogExternalRequest($external)) {
                $this->logger->info(
                    $this->requestMapper->mapExternalLogTitle($external),
                    $this->requestMapper->mapExternalLogContext($external),
                );
            }
        }
    }

    private function needToLogMainRequest(RequestInfo $request): bool
    {
        return !$this->rulesResolver || $this->rulesResolver->needToLogMainRequest($request);
    }

    private function needToLogExternalRequests(RequestInfo $request): bool
    {
        return !$this->rulesResolver || $this->rulesResolver->needToLogExternalRequests($request);
    }

    private function needToLogExternalRequest(RequestInfo $request): bool
    {
        return !$this->rulesResolver || $this->rulesResolver->needToLogExternalRequest($request);
    }
}

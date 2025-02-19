<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Logger;

use Bmwx591\RequestLogger\Mapper\RequestMapperInterface;
use Bmwx591\RequestLogger\RulesResolver\RulesResolverInterface;
use Psr\Log\LoggerInterface;

class RequestLogger
{
    private LoggerInterface $logger;

    private RequestMapperInterface $requestMapper;

    private ?RulesResolverInterface $rulesResolver;

    private ?WrappedRequest $incomingRequest = null;

    private ?WrappedResponse $outgoingResponse = null;

    /** @var array<ExternalRequest> */
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

        return $this;
    }

    public function outgoingResponse(WrappedResponse $response): self
    {
        $this->outgoingResponse = $response;

        return $this;
    }

    public function addExternal(ExternalRequest $external): self
    {
        $this->externals[] = $external;

        return $this;
    }

    public function pushLogs(): void
    {
        if ($this->needToLogMainRequest($this->incomingRequest, $this->outgoingResponse)) {
            $this->logger->info(
                $this->requestMapper->mapLogTitle($this->incomingRequest, $this->outgoingResponse),
                $this->requestMapper->mapLogContext($this->incomingRequest, $this->outgoingResponse),
            );
        }

        if ($this->needToLogExternalRequests($this->incomingRequest, $this->outgoingResponse)) {
            $this->pushExternalsLog();
        }
    }

    private function pushExternalsLog(): void
    {
        foreach ($this->externals as $external) {
            if ($this->needToLogExternalRequest($external->request(), $external->response())) {
                $this->logger->info(
                    $this->requestMapper->mapExternalLogTitle($external->request(), $external->response()),
                    $this->requestMapper->mapExternalLogContext($external->request(), $external->response()),
                );
            }
        }
    }

    private function needToLogMainRequest(
        ?WrappedRequest  $request,
        ?WrappedResponse $response
    ): bool {
        return !$this->rulesResolver || $this->rulesResolver->needToLogMainRequest($request, $response);
    }

    private function needToLogExternalRequests(
        ?WrappedRequest  $request,
        ?WrappedResponse $response
    ): bool {
        return !$this->rulesResolver || $this->rulesResolver->needToLogExternalRequests($request, $response);
    }

    private function needToLogExternalRequest(
        ?WrappedRequest  $request,
        ?WrappedResponse $response
    ): bool {
        return !$this->rulesResolver || $this->rulesResolver->needToLogExternalRequest($request, $response);
    }
}

<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Logger;

use Bmwx591\RequestLogger\Request\WrappedRequest;
use Bmwx591\RequestLogger\Response\WrappedResponse;
use DateTimeImmutable;
use DateTimeInterface;

class RequestInfo
{
    private WrappedRequest $request;

    private WrappedResponse $response;

    private DateTimeInterface $requestDate;

    public function __construct(
        WrappedRequest     $request,
        WrappedResponse    $response,
        ?DateTimeImmutable $requestDate = null
    ) {
        $this->request     = $request;
        $this->response    = $response;
        $this->requestDate = $requestDate ?? new DateTimeImmutable();
    }

    public function request(): WrappedRequest
    {
        return $this->request;
    }

    public function response(): WrappedResponse
    {
        return $this->response;
    }

    public function requestDate(): DateTimeInterface
    {
        return $this->requestDate;
    }
}

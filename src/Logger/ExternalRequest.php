<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Logger;

class ExternalRequest
{
    private WrappedRequest $request;

    private WrappedResponse $response;

    public function __construct(
        WrappedRequest  $request,
        WrappedResponse $response
    ) {
        $this->request  = $request;
        $this->response = $response;
    }

    public function request(): WrappedRequest
    {
        return $this->request;
    }

    public function response(): WrappedResponse
    {
        return $this->response;
    }
}

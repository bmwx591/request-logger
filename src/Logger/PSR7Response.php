<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Logger;

use Psr\Http\Message\ResponseInterface;

class PSR7Response implements WrappedResponse
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function originalResponse(): ResponseInterface
    {
        return $this->response;
    }
}

<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Request;

use Psr\Http\Message\RequestInterface;

class PSR7WrappedRequest implements WrappedRequest
{
    private RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function originalRequest(): RequestInterface
    {
        return $this->request;
    }
}

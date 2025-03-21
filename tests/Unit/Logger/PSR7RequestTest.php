<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Tests\Unit\Logger;

use Bmwx591\RequestLogger\Request\PSR7WrappedRequest;
use Bmwx591\RequestLogger\Request\WrappedRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class PSR7RequestTest extends TestCase
{
    public function testPsr7RequestWrapperCreation()
    {
        $request = $this->createStub(RequestInterface::class);
        $wrapper = new PSR7WrappedRequest($request);

        self::assertInstanceOf(WrappedRequest::class, $wrapper);
        self::assertInstanceOf(RequestInterface::class, $wrapper->originalRequest());
        self::assertSame($request, $wrapper->originalRequest());
    }
}

<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Tests\Unit\Logger;

use Bmwx591\RequestLogger\Response\PSR7WrappedResponse;
use Bmwx591\RequestLogger\Response\WrappedResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class PSR7ResponseTest extends TestCase
{
    public function testPsr7ResponseWrapperCreation()
    {
        $response = $this->createStub(ResponseInterface::class);
        $wrapper  = new PSR7WrappedResponse($response);

        self::assertInstanceOf(WrappedResponse::class, $wrapper);
        self::assertInstanceOf(ResponseInterface::class, $wrapper->originalResponse());
        self::assertSame($response, $wrapper->originalResponse());
    }
}

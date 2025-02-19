<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Tests\Unit\Logger;

use Bmwx591\RequestLogger\Logger\ExternalRequest;
use Bmwx591\RequestLogger\Logger\WrappedRequest;
use Bmwx591\RequestLogger\Logger\WrappedResponse;
use PHPUnit\Framework\TestCase;

class ExternalRequestTest extends TestCase
{
    /**
     * @return void
     */
    public function testExternalRequestCreation(): void
    {
        $wrappedRequest  = $this->createStub(WrappedRequest::class);
        $wrappedResponse = $this->createStub(WrappedResponse::class);

        $externalRequest = new ExternalRequest($wrappedRequest, $wrappedResponse);

        self::assertInstanceOf(WrappedRequest::class, $externalRequest->request());
        self::assertInstanceOf(WrappedResponse::class, $externalRequest->response());
        self::assertSame($wrappedRequest, $externalRequest->request());
        self::assertSame($wrappedResponse, $externalRequest->response());
    }
}

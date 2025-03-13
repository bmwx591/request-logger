<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Tests\Unit\Logger;

use Bmwx591\RequestLogger\Logger\ExternalRequest;
use Bmwx591\RequestLogger\Logger\WrappedRequest;
use Bmwx591\RequestLogger\Logger\WrappedResponse;
use DateTimeImmutable;
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
        $now = new DateTimeImmutable('+2 sec');

        $externalRequest = new ExternalRequest($wrappedRequest, $wrappedResponse, $now);

        self::assertInstanceOf(WrappedRequest::class, $externalRequest->request());
        self::assertInstanceOf(WrappedResponse::class, $externalRequest->response());
        self::assertInstanceOf(DateTimeImmutable::class, $externalRequest->requestDate());
        self::assertSame($wrappedRequest, $externalRequest->request());
        self::assertSame($wrappedResponse, $externalRequest->response());
        self::assertSame($now, $externalRequest->requestDate());
    }
}

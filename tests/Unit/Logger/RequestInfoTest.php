<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Tests\Unit\Logger;

use Bmwx591\RequestLogger\Logger\RequestInfo;
use Bmwx591\RequestLogger\Request\WrappedRequest;
use Bmwx591\RequestLogger\Response\WrappedResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class RequestInfoTest extends TestCase
{
    /**
     * @return void
     */
    public function testRequestCreation(): void
    {
        $wrappedRequest  = $this->createStub(WrappedRequest::class);
        $wrappedResponse = $this->createStub(WrappedResponse::class);
        $now             = new DateTimeImmutable('+2 sec');

        $request = new RequestInfo($wrappedRequest, $wrappedResponse, $now);

        self::assertInstanceOf(RequestInfo::class, $request);
        self::assertInstanceOf(WrappedRequest::class, $request->request());
        self::assertInstanceOf(WrappedResponse::class, $request->response());
        self::assertInstanceOf(DateTimeImmutable::class, $request->requestDate());
        self::assertSame($wrappedRequest, $request->request());
        self::assertSame($wrappedResponse, $request->response());
        self::assertSame($now, $request->requestDate());
    }
}

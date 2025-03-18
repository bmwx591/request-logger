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
     * @dataProvider dataProvider
     */
    public function testRequestCreation(bool $hasRequest, bool $hasResponse): void
    {
        $wrappedRequest  = $hasRequest ? $this->createStub(WrappedRequest::class) : null;
        $wrappedResponse = $hasResponse ? $this->createStub(WrappedResponse::class) : null;
        $now             = new DateTimeImmutable('+2 sec');

        $info = new RequestInfo($wrappedRequest, $wrappedResponse, $now);

        self::assertInstanceOf(RequestInfo::class, $info);

        if ($hasRequest) {
            self::assertInstanceOf(WrappedRequest::class, $info->request());
            self::assertSame($wrappedRequest, $info->request());
        } else {
            self::assertNull($info->request());
        }

        if ($hasResponse) {
            self::assertInstanceOf(WrappedResponse::class, $info->response());
            self::assertSame($wrappedResponse, $info->response());
        } else {
            self::assertNull($info->response());
        }

        self::assertInstanceOf(DateTimeImmutable::class, $info->requestDate());
        self::assertSame($now, $info->requestDate());
    }

    public function dataProvider(): array
    {
        return [
            'all data' => [true, true],
            'only request' => [true, false],
            'only response' => [false, true],
            'empty data' => [false, false],
        ];
    }
}

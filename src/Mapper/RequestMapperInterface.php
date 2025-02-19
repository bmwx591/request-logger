<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Mapper;

use Bmwx591\RequestLogger\Logger\WrappedRequest;
use Bmwx591\RequestLogger\Logger\WrappedResponse;

interface RequestMapperInterface
{
    public function mapLogTitle(?WrappedRequest $request, ?WrappedResponse $response): string;

    public function mapExternalLogTitle(?WrappedRequest $request, ?WrappedResponse $response): string;

    public function mapLogContext(?WrappedRequest $request, ?WrappedResponse $response): array;

    public function mapExternalLogContext(?WrappedRequest $request, ?WrappedResponse $response): array;
}

<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Mapper;

use Bmwx591\RequestLogger\Logger\RequestInfo;

interface RequestMapperInterface
{
    public function mapLogTitle(RequestInfo $request): string;

    public function mapExternalLogTitle(RequestInfo $request): string;

    public function mapLogContext(RequestInfo $request): array;

    public function mapExternalLogContext(RequestInfo $request): array;
}

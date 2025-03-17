<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Mapper;

use Bmwx591\RequestLogger\Logger\RequestInfo;

interface RequestMapperInterface
{
    public function mapLogTitle(RequestInfo $info): string;

    public function mapExternalLogTitle(RequestInfo $info): string;

    public function mapLogContext(RequestInfo $info): array;

    public function mapExternalLogContext(RequestInfo $info): array;
}

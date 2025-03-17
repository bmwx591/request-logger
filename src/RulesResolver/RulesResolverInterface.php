<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\RulesResolver;

use Bmwx591\RequestLogger\Logger\RequestInfo;

interface RulesResolverInterface
{
    public function needToLogMainRequest(RequestInfo $info): bool;

    public function needToLogExternalRequests(RequestInfo $info): bool;

    public function needToLogExternalRequest(RequestInfo $info): bool;
}

<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\RulesResolver;

use Bmwx591\RequestLogger\Logger\WrappedRequest;
use Bmwx591\RequestLogger\Logger\WrappedResponse;

interface RulesResolverInterface
{
    public function needToLogMainRequest(
        ?WrappedRequest  $request,
        ?WrappedResponse $response
    ): bool;

    public function needToLogExternalRequests(
        ?WrappedRequest  $request,
        ?WrappedResponse $response
    ): bool;

    public function needToLogExternalRequest(
        ?WrappedRequest  $request,
        ?WrappedResponse $response
    ): bool;
}

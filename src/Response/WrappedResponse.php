<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Response;

interface WrappedResponse
{
    public function originalResponse();
}

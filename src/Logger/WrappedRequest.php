<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Logger;

interface WrappedRequest
{
    public function originalRequest();
}

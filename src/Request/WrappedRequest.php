<?php

declare(strict_types=1);

namespace Bmwx591\RequestLogger\Request;

interface WrappedRequest
{
    public function originalRequest();
}

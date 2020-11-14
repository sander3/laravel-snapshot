<?php

namespace Soved\Laravel\Snapshot\Contracts;

use GuzzleHttp\Psr7\Stream;

interface Snapshot
{
    public function take(string $url): Stream;
}

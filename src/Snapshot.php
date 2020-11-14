<?php

namespace Soved\Laravel\Snapshot;

use GuzzleHttp\Psr7\Stream;
use Illuminate\Support\Facades\Http;
use Soved\Laravel\Snapshot\Contracts\Snapshot as SnapshotContract;

class Snapshot implements SnapshotContract
{
    public function take(string $url): Stream
    {
        $parameters = [
            'url' => $url,
        ];

        $response = Http::withToken(config('snapshot.api_token'))
            ->post(config('snapshot.endpoint'), $parameters);

        // Throw an exception if a client or server error occurred...
        $response->throw();

        return $response->getBody();
    }
}

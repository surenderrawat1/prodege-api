<?php

namespace Surender\ProdegeApi\Services;

use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class TimeHelper
{
    public static function getRequestDate(): int
    {
        // return Cache::remember('prodege_offset', 300, function () {
        $clientTime = (int) round(microtime(true) * 1000); // milliseconds

        $client = new Client();
        $response = $client->get(config('prodege.base_url') . '/lookup-request-time-offset', [
            'query' => ['client_time' => $clientTime],
            'timeout' => 5, // Optional: prevent hanging
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $offset = $data['request_time_offset'] ?? 0;

        return $clientTime + $offset;
        //});
    }
}

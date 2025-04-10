<?php

namespace Surender\ProdegeApi\Services;

use Surender\ProdegeApi\Contracts\ProdegeApiInterface;

class NullProdegeService implements ProdegeApiInterface
{
    public function get(string $endpoint, array $params = [])
    {
        return json_encode([
            'success' => false,
            'message' => 'Prodege service not available.',
            'data' => [],
        ]);
    }

    public function post(string $endpoint, array $params = [])
    {
        return json_encode([
            'success' => false,
            'message' => 'Prodege service not available.',
            'data' => [],
        ]);
    }
}

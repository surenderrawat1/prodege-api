<?php

namespace Surender\ProdegeApi\Services;

class SignatureBuilder
{
    public static function generate(array $params): string
    {
        // 1. Sort the parameters by key (alphabetical)
        ksort($params);

        // 2. Build the key=value string separated by :
        $stringToSign = collect($params)
            ->map(fn($v, $k) => "$k=$v")
            ->implode(':');

        // 3. Prepend the secret
        $secret = config('prodege.secret');
        $utf8 = utf8_encode("$secret:$stringToSign");
        //$utf8 = mb_convert_encoding("$secret:$stringToSign", 'UTF-8', 'UTF-8');

        // 4. Hash and encode
        $hash = hash('sha256', $utf8, true);
        $base64 = base64_encode($hash);

        // 5. Replace characters for URL safe base64
        return str_replace(['+', '/', '='], ['-', '_', ''], $base64);
    }
}

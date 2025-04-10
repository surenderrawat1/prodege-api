<?php

namespace Surender\ProdegeApi\Contracts;

interface ProdegeApiInterface
{
    public function get(string $endpoint, array $params = []);
    public function post(string $endpoint, array $params = []);
}

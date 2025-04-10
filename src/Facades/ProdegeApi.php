<?php

namespace Surender\ProdegeApi\Facades;

use Illuminate\Support\Facades\Facade;
use Surender\ProdegeApi\Contracts\ProdegeApiInterface;

class ProdegeApi extends Facade
{
    public static function getFacadeAccessor()
    {
        return ProdegeApiInterface::class;
    }
}

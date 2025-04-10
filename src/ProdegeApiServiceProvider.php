<?php

namespace Surender\ProdegeApi;

use Illuminate\Support\ServiceProvider;
use Surender\ProdegeApi\Contracts\ProdegeApiInterface;
use Surender\ProdegeApi\Services\NullProdegeService;
use Surender\ProdegeApi\Services\ProdegeService;

class ProdegeApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/prodege.php', 'prodege');

        $this->app->singleton(ProdegeApiInterface::class, function () {
            if (config('prodege.base_url') && config('prodege.secret')) {
                return new ProdegeService();
            }

            return new NullProdegeService();
        });

        $this->app->alias(ProdegeApiInterface::class, 'prodege-client');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/prodege.php' => config_path('prodege.php'),
        ], 'prodege-config');
    }
}

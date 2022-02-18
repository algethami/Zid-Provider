<?php

namespace Algethami\Zid;

use Illuminate\Support\ServiceProvider;

class ZidServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'zid',
            function ($app) use ($socialite) {
                $config = $app['config']['services.zid'];
                return $socialite->buildProvider(ZidProvider::class, $config);
            }
        );
    }
}

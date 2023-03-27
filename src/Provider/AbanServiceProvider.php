<?php

namespace Raahin\Aban\Provider;

use Illuminate\Support\ServiceProvider;
use Raahin\Aban\SMSClient;
use Raahin\Aban\SSOAdmin;
use Raahin\Aban\SSOSuperAdmin;
use Raahin\Aban\SSOClient;

class AbanServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->bind('ssoclient', function(){
            return new SSOClient;
        });

        $this->app->bind('smsclient', function(){
            return new SMSClient;
        });

        $this->mergeConfigFrom(__DIR__.'/../Configs/main.php', 'aban');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Configs/main.php' => config_path('aban.php'),
        ], 'config');
    }
}
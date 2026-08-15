<?php

namespace Aimeos\Cms;

use Aimeos\Cms\Commands\AimeosImport;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as Provider;

class AimeosServiceProvider extends Provider
{
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AimeosImport::class,
            ]);
        }
    }

    public function boot(): void
    {
        $basedir = dirname(__DIR__);

        Schema::register($basedir, 'aimeos');
        View::addNamespace('aimeos', $basedir.'/views');

        RateLimiter::for(
            'aimeos-extension-builder',
            fn ($request) => Limit::perMinute(5)->by(strtolower($request->getHost()).'|'.$request->ip()),
        );

        $this->loadRoutesFrom($basedir.'/routes/aimeos.php');

        $this->publishes([$basedir.'/public' => public_path('vendor/cms/aimeos')], 'cms-theme');
    }
}

<?php

namespace Tricks\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['events']->listen('trick.view', 'Tricks\Events\ViewTrickHandler');
    }

    public function register()
    {

    }
}

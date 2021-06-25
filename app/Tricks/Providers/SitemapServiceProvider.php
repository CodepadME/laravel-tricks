<?php

namespace Tricks\Providers;

use Illuminate\Support\ServiceProvider;

class SitemapServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias('sitemap', 'Roumen\Sitemap\Sitemap');
    }
}

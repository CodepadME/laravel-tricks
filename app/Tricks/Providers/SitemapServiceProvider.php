<?php

namespace Tricks\Providers;

use Illuminate\Support\ServiceProvider;
use Tricks\Services\Sitemap\Builder;
use Tricks\Services\Sitemap\DataProvider;

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

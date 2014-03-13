<?php

namespace Tricks\Providers;

use Tricks\Services\Social\Disqus;
use Tricks\Services\Social\Github;
use Illuminate\Support\ServiceProvider;
use Guzzle\Service\Client as GuzzleClient;
use League\OAuth2\Client\Provider\Github as GithubProvider;

class SocialServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerGithub();
        $this->registerDisqus();
    }

    /**
     * Register the Github services.
     *
     * @return void
     */
    protected function registerGithub()
    {
        $this->app['github.provider'] = $this->app->share(function ($app) {
            return new GithubProvider($app['config']->get('social.github'));
        });

        $this->app['github'] = $this->app->share(function ($app) {
            $provider = $app['github.provider'];
            $config   = $app['config'];
            $users    = $app['Tricks\Repositories\UserRepositoryInterface'];
            $profiles = $app['Tricks\Repositories\ProfileRepositoryInterface'];

            return new Github($provider, $config, $users, $profiles);
        });
    }

    /**
     * Register the Disqus service.
     *
     * @return void
     */
    protected function registerDisqus()
    {
        $this->app['disqus'] = $this->app->share(function ($app) {
            $config = $app['config'];
            $client = new GuzzleClient($config->get('social.disqus.requestUrl'));

            return new Disqus($client, $config);
        });
    }
}

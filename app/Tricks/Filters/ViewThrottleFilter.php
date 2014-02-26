<?php

namespace Tricks\Filters;

use Illuminate\Session\Store;
use Illuminate\Config\Repository;

class ViewThrottleFilter
{
    /**
     * Config repository instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Session store instance.
     *
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * Create a new view throttle filter instance.
     *
     * @param  \Illuminate\Config\Repository  $config
     * @param  \Illuminate\Session\Store      $session
     * @return void
     */
    public function __construct(Repository $config, Store $session)
    {
        $this->config  = $config;
        $this->session = $session;
    }

    /**
     * Execute the route filter.
     *
     * @return void
     */
    public function filter()
    {
        $tricks = $this->getViewedTricks();

        if ($tricks !== null) {
            $tricks = $this->purgeExpiredTricks($tricks);

            $this->storeViewedTricks($tricks);
        }
    }

    /**
     * Get the recently viewed tricks from the session.
     *
     * @return array|null
     */
    protected function getViewedTricks()
    {
        return $this->session->get('viewed_tricks', null);
    }

    /**
     * Get the view throttle time from the config.
     *
     * @return int
     */
    protected function getThrottleTime()
    {
        return $this->config->get('config.view_throttle_time');
    }

    /**
     * Filter the tricks array, removing expired tricks.
     *
     * @param  array  $tricks
     * @return array
     */
    protected function purgeExpiredTricks(array $tricks)
    {
        $time         = time();
        $throttleTime = $this->getThrottleTime();

        return array_filter($tricks, function ($timestamp) use ($time, $throttleTime) {
            return ($timestamp + $throttleTime) > $time;
        });
    }

    /**
     * Store the recently viewed tricks in the session.
     *
     * @param  array  $tricks
     * @return void
     */
    protected function storeViewedTricks(array $tricks)
    {
        $this->session->put('viewed_tricks', $tricks);
    }
}

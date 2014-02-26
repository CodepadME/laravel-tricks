<?php

namespace Tricks\Services\Navigation;

use Illuminate\Auth\AuthManager;
use Illuminate\Config\Repository;

class Builder
{
    /**
     * Config repository instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Auth manager instance.
     *
     * @var \Illuminate\Auth\AuthManager
     */
    protected $auth;

    /**
     * Create a new Navigation Builder instance.
     *
     * @param  \Illuminate\Config\Repository  $config
     * @param  \Illuminate\Auth\AuthManager   $auth
     * @return void
     */
    public function __construct(Repository $config, AuthManager $auth)
    {
        $this->config = $config;
        $this->auth = $auth;
    }

    /**
     * Build the HTML navigation from the given config key.
     *
     * @param  string $url
     * @param  string $type
     * @return string
     */
    public function make($url, $type = 'menu')
    {
        $menu      = $this->getNavigationConfig($type);
        $html      = '';
        $hasActive = false;

        foreach ($menu as $item) {
            $isActive = false;

            if (! $hasActive && $this->isActiveItem($item, $url)) {
                $isActive = $hasActive = true;
            }


            $html .= $this->getNavigationItem($item, $isActive);
        }

        return $html;
    }

    /**
     * Load the navigation config for the given type.
     *
     * @param  string  $type
     * @return array
     */
    protected function getNavigationConfig($type)
    {
        return $this->config->get('navigation.' . $type);
    }

    /**
     * Determine whether the given item is currently active.
     * @param  array   $item
     * @param  string  $url
     * @return bool
     */
    protected function isActiveItem(array $item, $url)
    {
        foreach ($item['active'] as $active) {
            if (str_is($active, $url)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a parsed HTML navigation list item for the given item.
     *
     * @param  array  $item
     * @param  bool   $isActive
     * @return string
     */
    protected function getNavigationItem(array $item, $isActive)
    {
        $anchor = $this->getItemAnchor($item);

        return $this->wrapAnchor($anchor, $isActive);
    }

    /**
     * Get the HTML anchor link for the given item.
     *
     * @param  array  $item
     * @return string
     */
    protected function getItemAnchor(array $item)
    {
        return link_to_route($item['route'], $item['label']);
    }

    /**
     * Wrap the given anchor in a list item.
     *
     * @param  string  $anchor
     * @param  bool    $isActive
     * @return string
     */
    protected function wrapAnchor($anchor, $isActive)
    {
        $class = $isActive ? ' class="active"' : '';

        return '<li' . $class . '>' . $anchor . '</li>';
    }
}

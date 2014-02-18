<?php

namespace Tricks\Facades;

use Illuminate\Support\Facades\Facade;

class Disqus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'disqus';
    }
}

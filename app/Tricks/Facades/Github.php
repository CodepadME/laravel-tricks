<?php

namespace Tricks\Facades;

use Illuminate\Support\Facades\Facade;

class Github extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'github';
    }
}

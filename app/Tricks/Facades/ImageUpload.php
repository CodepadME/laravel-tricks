<?php

namespace Tricks\Facades;

use Illuminate\Support\Facades\Facade;

class ImageUpload extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'upload.image';
    }
}

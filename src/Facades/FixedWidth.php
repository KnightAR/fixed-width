<?php

namespace TeamZac\FixedWidth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TeamZac\FixedWidth\FixedWidthParser
 */
class FixedWidthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fixed-width';
    }
}

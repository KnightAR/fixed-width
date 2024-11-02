<?php

namespace TeamZac\FixedWidth\Facades;

use Illuminate\Support\Facades\Facade;
use TeamZac\FixedWidth\FixedWidthParser;

/**
 * @see \TeamZac\FixedWidth\FixedWidthParser
 */
class FixedWidth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FixedWidthParser::class;
    }
}

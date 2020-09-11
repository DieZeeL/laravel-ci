<?php

namespace diezeel\CI\Facades;

use Illuminate\Support\Facades\Facade;

class Ci extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ci';
    }
}

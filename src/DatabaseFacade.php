<?php

namespace DevDojo\Database;

use Illuminate\Support\Facades\Facade;

/**
 * @see DatabaseFacade
 */
class DatabaseFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'database';
    }
}

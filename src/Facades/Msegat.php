<?php

namespace BitcodeSa\Msegat\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BitcodeSa\Msegat\Msegat
 */
class Msegat extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \BitcodeSa\Msegat\Msegat::class;
    }
}

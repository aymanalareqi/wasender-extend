<?php

namespace Alareqi\WasenderExtend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Alareqi\WasenderExtend\WasenderExtend
 */
class WasenderExtend extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Alareqi\WasenderExtend\WasenderExtend::class;
    }
}

<?php

namespace Zdrojowa\Amqp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static consume(array|string|null $argument, array $array, bool $true)
 */
class Amqp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'amqp';
    }

}

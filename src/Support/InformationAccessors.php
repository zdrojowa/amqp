<?php

namespace Zdrojowa\Amqp\Support;

use MyCLabs\Enum\Enum;

/**
 * @method static CONNECTION()
 * @method static EXCHANGE()
 * @method static AUTHENTICATION()
 * @method static QUEUE()
 * @method static CONSUMER()
 */
class InformationAccessors extends Enum
{
    private const AUTHENTICATION = 'authentication';
    private const CONNECTION = 'connection';
    private const QUEUE = 'queue';
    private const EXCHANGE = 'exchange';
    private const CONSUMER = 'consumer';

}

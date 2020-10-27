<?php

namespace Zdrojowa\Amqp\Contracts;

use Zdrojowa\Amqp\Interfaces\Propertiable;
use Zdrojowa\Amqp\Traits\hasAmqpProperties;

abstract class Information implements Propertiable
{
    use hasAmqpProperties;
}

<?php

namespace Zdrojowa\Amqp\Contracts;

use Zdrojowa\Amqp\Interfaces\Publishable;

abstract class Producer extends AmqpSupport implements Publishable
{
    public function onQueue(string $queueName): Producer
    {
        return $this;
    }



}

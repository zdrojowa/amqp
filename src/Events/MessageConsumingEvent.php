<?php

namespace Zdrojowa\Amqp\Events;

use Zdrojowa\Amqp\Contracts\AmqpSupport;
use Zdrojowa\Amqp\Contracts\Consumer;

class MessageConsumingEvent
{
    /**
     * @var AmqpSupport
     */
    private AmqpSupport $consumer;

    public function __construct(AmqpSupport $consumer)
    {
        $this->consumer = $consumer;
    }

    public function getConsumer() {
        return $this->consumer;
    }
}

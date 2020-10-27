<?php

namespace Zdrojowa\Amqp\Contracts;

use Illuminate\Support\Facades\Config;

abstract class AmqpSupport
{
    protected string $queueName;

    protected string $connectionName;

    protected string $routing = '';

    /**
     * @return mixed
     */
    public function getQueueName(): string
    {
        return $this->queueName ?? Config::get('amqp.queue');
    }

    /**
     * @return mixed
     */
    public function getConnectionName(): string
    {
        return $this->connectionName ?? Config::get('amqp.connection');
    }

    /**
     * @return string
     */
    public function getRouting(): string
    {
        return $this->routing;
    }

    public function onConnection(string $connection): AmqpSupport {
        $this->connectionName = $connection;

        return $this;
    }

    public function onQueue(string $queueName): AmqpSupport {
        $this->queueName = $queueName;

        return $this;
    }

}

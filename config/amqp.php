<?php

return [

    'connection' => 'rabbitmq',
    'queue' => 'default',

    'connections' => [
        'rabbitmq' => [
            'connection' => [
                'host' => 'localhost',
                'port' => 5672,
                'vhost' => '/',
                'ssl' => [],
                'timeout' => 0,
                'persistent' => false,
            ],
            'authentication' => [
                'username' => 'guest',
                'password' => 'guest',
            ],


            'queue' => [
                'forceDeclare' => true,
                'passive' => false,
                'durable' => true,
                'exclusive' => false,
                'autoDelete' => false,
                'noWait' => false,
                'properties' => ['x-ha-policy' => ['S', 'all']]
            ],

            'exchange' => [
                'exchange' => 'amq.topic',
                'type' => 'topic',
                'passive' => false,
                'durable' => true,
                'autoDelete' => false,
                'internal' => false,
                'noWait' => false,
                'properties' => []
            ],

            'consumer' => [
                'tag' => '',
                'noLocal' => false,
                'noAck' => false,
                'exclusive' => false,
                'noWait' => false,
                'autoStopConsume' => false
            ],

            'qos' => [
                'qos' => false,
                'prefetch' => [
                    'size' => 0,
                    'count' => 1
                ],
                'global' => false
            ]
        ],
    ],

    'consumers' => [
        'xd' => \Zdrojowa\Amqp\TestConsumer::class,
    ]
];

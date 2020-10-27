<?php

namespace Zdrojowa\Amqp;

use Zdrojowa\Amqp\Contracts\Producer;
use Zdrojowa\Amqp\Exceptions\ClassPropertyAccessorNotFound;
use Zdrojowa\Amqp\Support\InformationAccessors;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class AmqpPublisher
 * @package Zdrojowa\Amqp
 */
class AmqpPublisher extends AmqpConnection
{
    /**
     * AmqpPublisher constructor.
     *
     * @param Producer $producer
     * @param array $customProperties
     *
     * @throws ClassPropertyAccessorNotFound
     */
    public function __construct(Producer $producer, array $customProperties = [])
    {
        parent::__construct($producer, $customProperties);
    }

    /**
     * @return AmqpConnection
     */
    public function publish(): AmqpConnection
    {
        $this->getChannel()->basic_publish(
            new AMQPMessage($this->getAmqpSupport()->produce(), ['content_type' => 'text/plain', 'delivery_mode' => 2]),
                $this->getInformationCollector()->getProperty(InformationAccessors::EXCHANGE(), 'exchange'),
                $this->getAmqpSupport()->getRouting()
            );

        return $this;
    }
}

<?php

namespace Zdrojowa\Amqp;

use Exception;
use Illuminate\Support\Facades\Config;
use Zdrojowa\Amqp\Contracts\AmqpSupport;
use Zdrojowa\Amqp\Contracts\InformationCollector;
use Zdrojowa\Amqp\Exceptions\ClassPropertyAccessorNotFound;
use Zdrojowa\Amqp\Information\InformationCollectorFactory;
use Zdrojowa\Amqp\Support\InformationAccessors;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class AmqpConnection
 * @package Zdrojowa\Amqp
 */
class AmqpConnection
{
    /**
     * @var InformationCollector
     */
    private InformationCollector $informationCollector;
    /**
     * @var AMQPChannel
     */
    private AMQPChannel $channel;

    /**
     * @var AmqpSupport
     */
    protected AmqpSupport $amqpSupport;
    /**
     * @var AbstractConnection
     */
    private AbstractConnection $connection;

    /**
     * @var array|null
     */
    private ?array $queue;

    /**
     * AmqpConnection constructor.
     *
     * @param AmqpSupport $amqpSupport
     * @param array $customProperties
     *
     * @throws ClassPropertyAccessorNotFound
     */
    public function __construct(AmqpSupport $amqpSupport, array $customProperties = []) {
        $this->amqpSupport = $amqpSupport;
        $this->informationCollector = (new InformationCollectorFactory())->buildInformationCollectorWithAllInformations(Config::get('amqp.connections.' . $this->amqpSupport->getConnectionName()));

        foreach ($customProperties as $key => $value) {
            if (is_array($value)) {
                $key = strtoupper($key);
                try {
                    $accessor = InformationAccessors::$key();

                    $this->fillProperties($accessor, $value);
                } catch (\BadMethodCallException $exception) {
                    continue;
                };
            }
        }

        $this->connect();
        $this->declareExchange();
        $this->declareQueue();
    }

    /**
     * @param InformationAccessors $informationAccessor
     * @param array $keys
     */
    private function fillProperties(InformationAccessors $informationAccessor, array $keys)
    {
        foreach ($keys as $key => $value) {
            $this->informationCollector->setProperty($informationAccessor, $key, $value);
        }
    }

    /**
     *
     */
    public function connect()
    {
        $ssl = $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'ssl');

        if ($ssl) {
            $this->connection = new AMQPSSLConnection(
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'host'), $this->informationCollector->getProperty(
                InformationAccessors::CONNECTION(), 'port'), $this->informationCollector->getProperty(
                InformationAccessors::AUTHENTICATION(), 'username'), $this->informationCollector->getProperty(
                InformationAccessors::AUTHENTICATION(), 'password'), $this->informationCollector->getProperty(
                InformationAccessors::CONNECTION(), 'vhost'), $ssl, $this->informationCollector->getProperty(
                InformationAccessors::CONNECTION(), 'options'));
        } else {
            $this->connection = new AMQPStreamConnection(
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'host'),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'port'),
                $this->informationCollector->getProperty(InformationAccessors::AUTHENTICATION(), 'username'),
                $this->informationCollector->getProperty(InformationAccessors::AUTHENTICATION(), 'password'),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'vhost'),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.insist', false),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.login_method', 'AMQPLAIN'),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.login_response', null),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.locale', 3),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.connection_timeout', 3.0),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.read_write_timeout', 3.0),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.context', null),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.keepalive', false),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.heartbeat', 0),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.channel_rpc_timeout', 0.0),
                $this->informationCollector->getProperty(InformationAccessors::CONNECTION(), 'options.ssl_protocol', null)
            );
        }

        $this->connection->set_close_on_destruct(true);

        $this->channel = $this->connection->channel();
    }

    /**
     *
     */
    public function declareExchange()
    {
        $this->channel->exchange_declare(
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'exchange'),
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'type'),
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'passive'),
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'durable'),
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'autoDelete'),
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'internal'),
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'noWait'),
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'properties'));
    }

    /**
     *
     */
    public function declareQueue(): void
    {
        if ($this->amqpSupport->getQueueName() || $this->informationCollector->getProperty(InformationAccessors::QUEUE(), 'forceDeclare')) {
            $this->queue = $this->channel->queue_declare(
                $this->amqpSupport->getQueueName(),
                $this->informationCollector->getProperty(InformationAccessors::QUEUE(), 'passive'),
                $this->informationCollector->getProperty(InformationAccessors::QUEUE(), 'durable'),
                $this->informationCollector->getProperty(InformationAccessors::QUEUE(), 'exclusive'),
                $this->informationCollector->getProperty(InformationAccessors::QUEUE(), 'autoDelete'),
                $this->informationCollector->getProperty(InformationAccessors::QUEUE(), 'noWait'),
                $this->informationCollector->getProperty(InformationAccessors::QUEUE(), 'properties')
            );

            $this->bindQueue();
        }
    }

    /**
     *
     */
    private function bindQueue(): void
    {
        $this->channel->queue_bind(
            $this->amqpSupport->getQueueName() ? : $this->queue[0],
            $this->informationCollector->getProperty(InformationAccessors::EXCHANGE(), 'exchange'),
            $this->amqpSupport->getRouting());
    }

    /**
     * @return InformationCollector
     */
    public function getInformationCollector(): InformationCollector
    {
        return $this->informationCollector;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    /**
     * @return AmqpSupport
     */
    public function getAmqpSupport(): AmqpSupport
    {
        return $this->amqpSupport;
    }

    /**
     * @return AbstractConnection
     */
    public function getConnection(): AbstractConnection
    {
        return $this->connection;
    }

    /**
     * @return int|mixed
     */
    public function queueSize()
    {
        if (is_array($this->queue)) {
            return $this->queue[1];
        }

        return 0;
    }

    /**
     *
     */
    public function closeCurrentConnection(): void
    {
        self::closeConnection(
            $this->getChannel(), $this->getConnection());
    }

    /**
     * @param AMQPChannel $channel
     * @param AbstractConnection $connection
     *
     * @throws Exception
     */
    public static function closeConnection(AMQPChannel $channel, AbstractConnection $connection): void
    {
        $channel->close();
        $connection->close();
    }

}

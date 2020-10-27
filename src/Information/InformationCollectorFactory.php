<?php

namespace Zdrojowa\Amqp\Information;

use Zdrojowa\Amqp\Contracts\InformationCollector as InformationCollectorContract;
use Zdrojowa\Amqp\Contracts\InformationCollectorFactory as InformationCollectorFactoryContract;
use Zdrojowa\Amqp\Exceptions\ClassPropertyAccessorNotFound;

/**
 * Class InformationCollectorFactory
 * @package Zdrojowa\Amqp\Information
 */
class InformationCollectorFactory implements InformationCollectorFactoryContract
{

    /**
     * @param array $configArray
     *
     * @return InformationCollectorContract
     * @throws ClassPropertyAccessorNotFound
     */
    public function buildInformationCollectorWithAllInformations(array $configArray): InformationCollectorContract
    {
        return (new InformationCollector())->addInformation(
            new AuthenticationInformation($configArray),
            new ConsumerInformation($configArray),
            new ConnectionInformation($configArray),
            new ExchangeInformation($configArray),
            new QueueInformation($configArray)
        );
    }
}

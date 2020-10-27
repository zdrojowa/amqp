<?php

namespace Zdrojowa\Amqp\Contracts;

interface InformationCollectorFactory
{
    public function buildInformationCollectorWithAllInformations(array $configArray): InformationCollector;
}

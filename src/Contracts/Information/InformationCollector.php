<?php

namespace Zdrojowa\Amqp\Contracts;

use Zdrojowa\Amqp\Support\InformationAccessors;

interface InformationCollector
{
    public function getProperty(InformationAccessors $informationAccessors, string $key, string $default = null);

    public function addInformation(Information ...$information): InformationCollector;

    public function setProperty(InformationAccessors $informationAccessors, string $key, $value);
}

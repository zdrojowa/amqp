<?php

namespace Zdrojowa\Amqp\Annotations;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class AmqpProperty
{
    public $name;

    public $default = null;
}

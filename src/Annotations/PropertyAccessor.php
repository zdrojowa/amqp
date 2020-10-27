<?php

namespace Zdrojowa\Amqp\Annotations;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class PropertyAccessor
 * @package Zdrojowa\Amqp\Annotations
 * @Annotation
 * @Target({"CLASS"})
 */
class PropertyAccessor
{
    public $name;
}

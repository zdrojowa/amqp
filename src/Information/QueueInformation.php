<?php

namespace Zdrojowa\Amqp\Information;

use Zdrojowa\Amqp\Annotations\PropertyAccessor;
use Zdrojowa\Amqp\Contracts\QueueInformation as QueueInformationContract;

/**
 * Class QueueInformation
 * @package Zdrojowa\Amqp\Information
 *
 * @PropertyAccessor(name="queue")
 */
class QueueInformation extends QueueInformationContract
{

}

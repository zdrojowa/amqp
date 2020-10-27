<?php

namespace Zdrojowa\Amqp\Information;

use Zdrojowa\Amqp\Annotations\PropertyAccessor;
use Zdrojowa\Amqp\Contracts\ConnectionInformation as ConnectionInformationContract;

/**
 * Class ConnectionInformation
 * @package Zdrojowa\Amqp\Information
 *
 * @PropertyAccessor(name="connection")
 */
class ConnectionInformation extends ConnectionInformationContract
{

}

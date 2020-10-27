<?php

namespace Zdrojowa\Amqp\Information;

use Zdrojowa\Amqp\Annotations\PropertyAccessor;
use Zdrojowa\Amqp\Contracts\ExchangeInformation as ExchangeInformationContract;

/**
 * Class ExchangeInformation
 * @package Zdrojowa\Amqp\Information
 *
 * @PropertyAccessor(name="exchange")
 */
class ExchangeInformation extends ExchangeInformationContract
{

}

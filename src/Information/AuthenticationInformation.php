<?php

namespace Zdrojowa\Amqp\Information;

use Zdrojowa\Amqp\Annotations\PropertyAccessor;
use Zdrojowa\Amqp\Contracts\AuthenticationInformation as AuthenticationInformationContract;

/**
 * Class AuthenticationInformation
 * @package Zdrojowa\Amqp\Information
 *
 * @PropertyAccessor(name="authentication")
 */
class AuthenticationInformation extends AuthenticationInformationContract
{

}

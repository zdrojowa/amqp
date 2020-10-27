<?php

namespace Zdrojowa\Amqp\Contracts;

use Zdrojowa\Amqp\Annotations\AmqpProperty;
use Zdrojowa\Amqp\Annotations\PropertyAccessor;

/**
 * Class AuthenticationInformation
 * @package Zdrojowa\Amqp\Second\Contracts
 *
 * @PropertyAccessor(name="authentication")
 */
abstract class AuthenticationInformation extends Information
{
    /**
     * @AmqpProperty(name="username", default="guest")
     */
    protected string $username;

    /**
     * @AmqpProperty(name="password", default="guest")
     */
    protected string $password;

}

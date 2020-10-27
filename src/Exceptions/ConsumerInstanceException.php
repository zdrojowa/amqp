<?php

namespace Zdrojowa\Amqp\Exceptions;

use Exception;
use Zdrojowa\Amqp\Contracts\Consumer;
use Throwable;

/**
 * Class ConsumerInstanceException
 * @package Zdrojowa\Amqp\Exceptions
 */
class ConsumerInstanceException extends Exception
{
    /**
     * ConsumerInstanceException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message . " should be instance of " . Consumer::class, $code, $previous);
    }

}

<?php

namespace Zdrojowa\Amqp\Exceptions;

use Exception;
use Throwable;

/**
 * Class ClassPropertyAccessorNotFound
 * @package Zdrojowa\Amqp\Exceptions
 */
class ClassPropertyAccessorNotFound extends Exception
{
    /**
     * ClassPropertyAccessorNotFound constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Property accessor not found in " . $message . " class", $code, $previous);
    }

}

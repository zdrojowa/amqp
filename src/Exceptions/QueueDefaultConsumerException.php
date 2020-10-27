<?php

namespace Zdrojowa\Amqp\Exceptions;

use Exception;
use Throwable;

class QueueDefaultConsumerException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Queue '.$message.' consumer is not set.', $code, $previous);
    }

}

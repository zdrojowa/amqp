<?php

namespace Zdrojowa\Amqp\Interfaces;

interface Publishable
{
    public function produce(): string;
}

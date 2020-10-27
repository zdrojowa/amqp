<?php

namespace Zdrojowa\Amqp\Interfaces;

/**
 * Interface Consumable
 * @package Zdrojowa\Amqp\Interfaces
 */
interface Consumable
{
    public function consume(): void;

    public function acknowledge(): void;

    public function reject(): void;
}

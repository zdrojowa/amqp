<?php

namespace Zdrojowa\Amqp\Interfaces;

/**
 * Interface Propertiable
 * @package Zdrojowa\Amqp\Interfaces
 */
interface Propertiable
{
    /**
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function property(string $key, $default = null);

    /**
     * @return string
     */
    public function getPropertyAccessor(): string;

    /**
     * @param string $key
     * @param $value
     *
     * @return mixed
     */
    public function setProperty(string $key, $value);
}

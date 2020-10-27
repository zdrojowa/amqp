<?php

namespace Zdrojowa\Amqp\Information;

use Illuminate\Support\Collection;
use Zdrojowa\Amqp\Contracts\Information;
use Zdrojowa\Amqp\Contracts\InformationCollector as InformationCollectorContract;
use Zdrojowa\Amqp\Exceptions\ClassPropertyAccessorNotFound;
use Zdrojowa\Amqp\Support\InformationAccessors;

/**
 * Class InformationCollector
 * @package Zdrojowa\Amqp\Information
 */
class InformationCollector implements InformationCollectorContract
{

    /**
     * @var Collection
     */
    private $informations;

    /**
     * InformationCollector constructor.
     */
    public function __construct()
    {
        $this->informations = new Collection();
    }

    /**
     * @param InformationAccessors $informationAccessors
     * @param string $key
     * @param string|null $default
     *
     * @return mixed
     */
    public function getProperty(InformationAccessors $informationAccessors, string $key, string $default = null)
    {
        return $this->informations->get($informationAccessors->getValue(), $default)->property($key, $default);
    }

    /**
     * @param Information ...$informations
     *
     * @return InformationCollectorContract
     * @throws ClassPropertyAccessorNotFound
     */
    public function addInformation(Information ...$informations): InformationCollectorContract
    {
        foreach ($informations as $information) {
            $this->informations->put($information->getPropertyAccessor(), $information);
        }

        return $this;
    }

    /**
     * @param InformationAccessors $informationAccessors
     * @param string $key
     * @param $value
     */
    public function setProperty(InformationAccessors $informationAccessors, string $key, $value)
    {
        if ($this->informations->has($informationAccessors->getValue())) {
            $this->informations->get($informationAccessors->getValue())->setProperty($key, $value);
        }
    }
}

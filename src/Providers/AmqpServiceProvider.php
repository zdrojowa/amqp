<?php

namespace Zdrojowa\Amqp\Providers;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider;
use Zdrojowa\Amqp\Amqp;
use Zdrojowa\Amqp\Annotations\AmqpProperty;
use Zdrojowa\Amqp\Annotations\PropertyAccessor;
use Zdrojowa\Amqp\Console\Commands\QueueListenCommand;

class AmqpServiceProvider extends ServiceProvider
{

    public array $singletons = [
        'amqp' => Amqp::class,
    ];

    public function register()
    {
        $this->publishes([
            __DIR__ . '/../../config/amqp.php' => config_path('amqp.php'),
        ]);
    }
    
    public function boot() {
        $this->mergeConfigFrom(__DIR__ . '/../../config/amqp.php', 'amqp');

        AnnotationRegistry::registerFile(
            (new \ReflectionClass(AmqpProperty::class))->getFileName()
        );
        AnnotationRegistry::registerFile(
                (new \ReflectionClass(PropertyAccessor::class))->getFileName()
            );

        $this->commands([
            QueueListenCommand::class
        ]);
    }
}

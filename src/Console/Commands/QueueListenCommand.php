<?php

namespace Zdrojowa\Amqp\Console\Commands;

use Illuminate\Console\Command;
use Zdrojowa\Amqp\Events\MessageAcknowledgeEvent;
use Zdrojowa\Amqp\Events\MessageConsumingEvent;
use Zdrojowa\Amqp\Events\MessageRejectEvent;
use Zdrojowa\Amqp\Facades\Amqp;
use PhpAmqpLib\Exception\AMQPHeartbeatMissedException;

class QueueListenCommand extends Command
{

    protected $signature = 'amqp:listen {queue=default}';

    public function handle()
    {
        $this->info('Listening for messages in ' . $this->argument('queue') . ' queue.');
        $this->listenForEvents();

        while (true) {
            try {
                Amqp::consume(
                    $this->argument('queue'), [
                    'connection' => [
                        'persistent' => true,
                    ],
                    'consumer' => [
                        'autoStopConsume' => false,
                    ],
                ], true);
            } catch (\Exception $exception) {
                if($exception instanceof AMQPHeartbeatMissedException) {
                    continue;
                }

                $this->error($exception->getMessage());
            }
        }
    }

    private function listenForEvents()
    {
        $this->laravel['events']->listen(
            MessageAcknowledgeEvent::class, function($event) {
            $this->info('Consumed');
        });

        $this->laravel['events']->listen(
            MessageRejectEvent::class, function($event) {
            $this->error('Rejected');
        });
    }

}

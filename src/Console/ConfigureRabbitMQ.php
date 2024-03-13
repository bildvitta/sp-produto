<?php

namespace BildVitta\SpProduto\Console;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConfigureRabbitMQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sp-produto:configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates initial config for message broker';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! env('RABBITMQ_ACTIVE', false)) {
            $this->info('RabbitMQ não está ativado! Ignorando configuração inicial...');

            return 0;
        }

        $host = config('sp-produto.rabbitmq.host');
        $port = config('sp-produto.rabbitmq.port');
        $user = config('sp-produto.rabbitmq.user');
        $password = config('sp-produto.rabbitmq.password');
        $vhost = config('sp-produto.rabbitmq.virtualhost');

        $exchangeNameRealEstateDevelopments = config('sp-produto.rabbitmq.exchange.real_estate_developments');
        $queueNameRealEstateDevelopments = config('sp-produto.rabbitmq.queue.real_estate_developments');

        $exchangeNameProperties = config('sp-produto.rabbitmq.exchange.properties');
        $queueNameProperties = config('sp-produto.rabbitmq.queue.properties');

        $connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
        $channel = $connection->channel();

        $channel->exchange_declare($exchangeNameRealEstateDevelopments, 'fanout', false, true, false);
        $channel->queue_declare($queueNameRealEstateDevelopments, false, true, false, false);
        $channel->queue_bind($queueNameRealEstateDevelopments, $exchangeNameRealEstateDevelopments);

        $channel->exchange_declare($exchangeNameProperties, 'fanout', false, true, false);
        $channel->queue_declare($queueNameProperties, false, true, false, false);
        $channel->queue_bind($queueNameProperties, $exchangeNameProperties);

        $channel->close();
        $connection->close();

        $this->info('Configuração do RabbitMQ efetuada com sucesso!');

        return 0;
    }
}

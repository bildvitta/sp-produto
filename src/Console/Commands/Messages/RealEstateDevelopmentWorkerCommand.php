<?php

namespace BildVitta\SpProduto\Console\Commands\Messages;

use BildVitta\SpProduto\Console\Commands\Messages\Resources\RealEstateDevelopmentMessageProcessor;
use Illuminate\Console\Command;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use Throwable;

class RealEstateDevelopmentWorkerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmqworker:real_estate_developments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets and processes messages';

    /**
     * @var AMQPStreamConnection
     */
    private $connection = null;

    /**
     * @var AMQPChannel
     */
    private $channel;

    private RealEstateDevelopmentMessageProcessor $realEstateDevelopmentMessageProcessor;

    public function __construct(RealEstateDevelopmentMessageProcessor $realEstateDevelopmentMessageProcessor)
    {
        parent::__construct();
        $this->realEstateDevelopmentMessageProcessor = $realEstateDevelopmentMessageProcessor;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        while (true) {
            try {
                $this->process();
            } catch (AMQPExceptionInterface $exception) {
                $this->closeChannel();
                $this->closeConnection();
                sleep(5);
            }
        }

        return 0;
    }

    private function process(): void
    {
        $this->connect();
        $this->channel = $this->connection->channel();

        $queueName = config('sp-produto.rabbitmq.queue.real_estate_developments');
        $callback = [$this->realEstateDevelopmentMessageProcessor, 'process'];
        $this->channel->basic_consume(
            queue: $queueName,
            callback: $callback
        );

        $this->channel->consume();

        $this->closeChannel();
        $this->closeConnection();
    }

    private function closeChannel(): void
    {
        try {
            if ($this->channel) {
                $this->channel->close();
                $this->channel = null;
            }
        } catch (Throwable $exception) {
        }
    }

    private function closeConnection(): void
    {
        try {
            if ($this->connection) {
                $this->connection->close();
                $this->connection = null;
            }
        } catch (Throwable $exception) {
        }
    }

    private function connect(): void
    {
        $host = config('sp-produto.rabbitmq.host');
        $port = config('sp-produto.rabbitmq.port');
        $user = config('sp-produto.rabbitmq.user');
        $password = config('sp-produto.rabbitmq.password');
        $virtualhost = config('sp-produto.rabbitmq.virtualhost');
        $heartbeat = 20;
        $sslOptions = [
            'verify_peer' => false,
        ];
        $options = [
            'heartbeat' => $heartbeat,
        ];

        if (app()->isLocal()) {
            $this->connection = new AMQPStreamConnection(
                host: $host,
                port: $port,
                user: $user,
                password: $password,
                vhost: $virtualhost,
                heartbeat: $heartbeat
            );
        } else {
            $this->connection = new AMQPSSLConnection(
                host: $host,
                port: $port,
                user: $user,
                password: $password,
                vhost: $virtualhost,
                ssl_options: $sslOptions,
                options: $options
            );
        }
    }
}

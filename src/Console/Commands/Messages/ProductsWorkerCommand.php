<?php

namespace BildVitta\SpProduto\Console\Commands\Messages;

use BildVitta\SpProduto\Console\Commands\Messages\Resources\MessageProduct;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use PhpAmqpLib\Channel\AMQPChannel;

class ProductsWorkerCommand extends Command
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

    /**
     * @var MessageProduct
     */
    private MessageProduct $messageProduct;

    /**
     * @param MessageProduct $messageProduct
     */
    public function __construct(MessageProduct $messageProduct)
    {
        parent::__construct();
        $this->messageProduct = $messageProduct;
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

    /**
     * @return void
     */
    private function process(): void
    {
        $this->connect();
        $this->channel = $this->connection->channel();
        
        $queueName = config('sp-produto.rabbitmq.queue.real_estate_developments');
        $callback = [$this->messageProduct, 'process'];
        $this->channel->basic_consume(
            queue: $queueName,
            callback: $callback
        );

        $this->channel->consume();
        
        $this->closeChannel();
        $this->closeConnection();
    }

    /**
     * @return void
     */
    private function closeChannel(): void
    {
        try {
            if ($this->channel) {
                $this->channel->close();
            }
        } catch (Exception $exception) {
        }
    }

    /**
     * @return void
     */
    private function closeConnection(): void
    {
        try {
            if ($this->connection) {
                $this->connection->close();
            }
        } catch (Exception $exception) {
        }
    }

    /**
     * @return void
     */
    private function connect(): void
    {
        $host = config('sp-produto.rabbitmq.host');
        $port = config('sp-produto.rabbitmq.port');
        $user = config('sp-produto.rabbitmq.user');
        $password = config('sp-produto.rabbitmq.password');
        $virtualhost = config('sp-produto.rabbitmq.virtualhost');
        $heartbeat = 20;
        $sslOptions = [
            'verify_peer' => false
        ];
        $options = [
            'heartbeat' => $heartbeat
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

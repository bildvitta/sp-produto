<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources;

trait Connection
{
    private function configConnection(): void
    {
        config([
            'database.connections.produto' => [
                'driver' => 'mysql',
                'host' => config('sp-produto.db.host'),
                'port' => config('sp-produto.db.port'),
                'database' => config('sp-produto.db.database'),
                'username' => config('sp-produto.db.username'),
                'password' => config('sp-produto.db.password'),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => [],
            ],
        ]);
    }
}

<?php

return [
    'table_prefix' => env('MS_SP_PRODUTO_TABLE_PREFIX', 'produto_'),
    'db' => [
        'host' => env('PRODUTO_DB_HOST', '127.0.0.1'),
        'port' => env('PRODUTO_DB_PORT', '3306'),
        'database' => env('PRODUTO_DB_DATABASE', 'forge'),
        'username' => env('PRODUTO_DB_USERNAME', 'forge'),
        'password' => env('PRODUTO_DB_PASSWORD', ''),
    ],
    'rabbitmq' => [
        'host' => env('RABBITMQ_HOST'),
        'port' => env('RABBITMQ_PORT', '5672'),
        'user' => env('RABBITMQ_USER'),
        'password' => env('RABBITMQ_PASSWORD'),
        'virtualhost' => env('RABBITMQ_VIRTUALHOST', '/'),
        'exchange' => [],
        'queue' => []
    ],
];

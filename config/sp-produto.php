<?php

use BildVitta\Hub\Entities\HubCompany;

return [
    'table_prefix' => env('MS_SP_PRODUTO_TABLE_PREFIX', 'produto_'),

    'model_company' => env('MS_SP_PRODUTO_COMPANY', HubCompany::class),

    'db' => [
        'host' => env('PRODUTO_DB_HOST', '127.0.0.1'),
        'port' => env('PRODUTO_DB_PORT', '3306'),
        'database' => env('PRODUTO_DB_DATABASE', 'forge'),
        'username' => env('PRODUTO_DB_USERNAME', 'forge'),
        'password' => env('PRODUTO_DB_PASSWORD', ''),
    ],

    'rabbitmq' => [
        'host' => env('RABBITMQ_HOST', 'b-5e375e25-4b8a-4777-a362-388150b78d9a.mq.us-east-1.amazonaws.com'),
        'port' => env('RABBITMQ_PORT', '5671'),
        'user' => env('RABBITMQ_USER', 'rabbittest'),
        'password' => env('RABBITMQ_PASSWORD', 'runkat-nyqred-3gyTxi'),
        'virtualhost' => env('RABBITMQ_VIRTUALHOST', '/'),
        'exchange' => [
            'real_estate_developments' => env('RABBITMQ_EXCHANGE_REAL_ESTATE_DEVELOPMENTS', 'real_estate_developments'),
        ],
        'queue' => [
            'real_estate_developments' => env('RABBITMQ_QUEUE_REAL_ESTATE_DEVELOPMENTS', 'real_estate_developments.vendas'),
        ]
    ],
];

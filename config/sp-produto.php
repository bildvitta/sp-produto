<?php

use BildVitta\Hub\Entities\HubCompany;

return [
    'table_prefix' => env('MS_SP_PRODUTO_TABLE_PREFIX', 'produto_'),

    'model_company' => env('MS_SP_PRODUTO_COMPANY', HubCompany::class),

    'db' => [
        'host' => env('PRODUTO_DB_HOST'),
        'port' => env('PRODUTO_DB_PORT'),
        'database' => env('PRODUTO_DB_DATABASE'),
        'username' => env('PRODUTO_DB_USERNAME'),
        'password' => env('PRODUTO_DB_PASSWORD'),
    ],

    'rabbitmq' => [
        'host' => env('RABBITMQ_HOST'),
        'port' => env('RABBITMQ_PORT'),
        'user' => env('RABBITMQ_USER'),
        'password' => env('RABBITMQ_PASSWORD'),
        'virtualhost' => env('RABBITMQ_VIRTUALHOST', '/'),
        'exchange' => [
            'real_estate_developments' => env('RABBITMQ_EXCHANGE_REAL_ESTATE_DEVELOPMENTS', 'real_estate_developments'),
        ],
        'queue' => [
            'real_estate_developments' => env('RABBITMQ_QUEUE_REAL_ESTATE_DEVELOPMENTS', 'real_estate_developments.vendas'),
        ]
    ],
];

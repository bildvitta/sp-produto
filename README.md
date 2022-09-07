[![Latest Version on Packagist](https://img.shields.io/packagist/v/bildvitta/sp-produto.svg?style=flat-square)](https://packagist.org/packages/bildvitta/sp-produto)
[![Total Downloads](https://img.shields.io/packagist/dt/bildvitta/sp-produto.svg?style=flat-square)](https://packagist.org/packages/bildvitta/sp-produto)

## Introduction

The SP (Space Probe) package is responsible for collecting remote data updates for the module, keeping the data structure similar as possible, through the message broker.

## Installation

You can install the package via composer:

```bash 
composer require bildvitta/sp-produto
```

For everything to work perfectly in addition to having the settings file published in your application, run the command below:

```bash
php artisan sp-produto:config
```

## Configuration

This is the contents of the published config file:

```php

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
            'real_estate_developments' => env('RABBITMQ_QUEUE_REAL_ESTATE_DEVELOPMENTS'),
        ]
    ],

    'sync_relations' => [
        'buying_options',
        'parameters',
        'insurances',
        'accessories',
        'mirrors', // need parameters
        'blueprints', // need typologies, accessories
        'characteristics',
        'proposal_models',
        'stages',
        'typologies', // need proposal_models
        'units', // need typologies, blueprints, mirrors 
        'documents',
        'media',
    ],
];
```

## Importing data

You can import initial data from the parent module by setting the database connection data in the configuration file. However, it will be necessary to import the data from the dependent module first: sp-hub.

```bash
php artisan dataimport:produto_real_estate_developments
```

## Database seeder

You can seed your database with fake data to work with. However, it will be necessary to seed the other dependency first: sp-hub.

```bash
php artisan db:seed --class=SpProdutoSeeder
```

## Running the worker

After setting the message broker access data in the configuration file, you can run the worker to keep the data up to date.

```bash
php artisan rabbitmqworker:real_estate_developments
```

Remove the relationships that you do not want to use, in order not to create the related tables, in the configuration file.

Some relationships require other relationships, indicated in the comments.

Run the command to install migrations and run seeds.

```bash
php artisan sp-produto:install
```

If you want to add some relationship later, add it to the settings array and run the above command again.

Comando para importar dados:

```bash
php artisan dataimport:produto_real_estate_developments
```

Comando para executar o worker do RabbitMQ:

```bash
php artisan rabbitmqworker:real_estate_developments
```
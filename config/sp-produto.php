<?php

use BildVitta\Hub\Entities\HubCompany;

return [
    'table_prefix' => env('MS_SP_PRODUTO_TABLE_PREFIX', 'produto_'),

    'model_company' => env('MS_SP_PRODUTO_COMPANY', HubCompany::class),
    'model_brand' => \BildVitta\SpProduto\Models\HubBrand::class,
    'model_real_estate_development' => \BildVitta\SpProduto\Models\RealEstateDevelopment::class,
    'model_unit' => \BildVitta\SpProduto\Models\RealEstateDevelopment\Unit::class,
    'model_blueprint' => \BildVitta\SpProduto\Models\RealEstateDevelopment\Blueprint::class,
    'model_proposal_model' => \BildVitta\SpProduto\Models\ProposalModel::class,
    'model_buying_option' => \BildVitta\SpProduto\Models\BuyingOption::class,
    'model_accessory_category' => \BildVitta\SpProduto\Models\AccessoryCategory::class,
    'model_accessory' => \BildVitta\SpProduto\Models\Accessory::class,
    'model_real_estate_development_accessory' => \BildVitta\SpProduto\Models\RealEstateDevelopment\Accessory::class,

    'model_properties' => \BildVitta\SpProduto\Models\Property::class,

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
        ],
    ],

    'sync_relations' => [
        'buying_options',
        'parameters', // need buying_options
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
        'properties',
    ],

    'events' => [
        'real_estate_development_updated' => env('RABBITMQ_EVENT_REAL_ESTATE_DEVELOPMENT_UPDATED', false),
    ],
];

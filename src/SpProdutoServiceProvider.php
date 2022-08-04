<?php

namespace BildVitta\SpProduto;

use BildVitta\SpProduto\Console\InstallSp;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * Class SpProdutoServiceProvider.
 *
 * @package BildVitta\SpProduto
 */
class SpProdutoServiceProvider extends PackageServiceProvider
{
    /**
     * @param  Package  $package
     *
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('sp-produto')
            ->hasConfigFile(['sp-produto'])
            ->hasMigrations([
                'create_sp_produto_real_estate_developments_table', // must be the first
                'create_sp_produto_insurance_companies_table', // must be before others insurance tables
                'create_sp_produto_insurances_table',
                'create_sp_produto_insurance_company_real_estate_development_table',
                'create_sp_produto_insurance_real_estate_development_table',
                'create_sp_produto_accessory_categories_table', // must be before the accessories table
                'create_sp_produto_accessories_table',
                'create_sp_produto_blueprints', // must be before others blueprints tables
                'create_sp_produto_blueprint_images_table',
                'create_sp_produto_blueprint_real_estate_development_accessory_table',
                'create_sp_produto_blueprint_typology_table',
                'create_sp_produto_buying_options_table', // must be before others buying options tables
                'create_sp_produto_buying_option_real_estate_development_table',
                'create_sp_produto_characteristics_table',
                'create_sp_produto_proposal_models_table', // must be before others proposal models tables
                'create_sp_produto_proposal_model_periodicities_table',
                'create_sp_produto_proposal_model_real_estate_development_table',
                'create_sp_produto_proposal_model_typology_table',
                'create_sp_produto_real_estate_development_accessories_table',
                'create_sp_produto_real_estate_development_characteristic_table',
                'create_sp_produto_stages_table',
                'create_sp_produto_typologies_table', // must be before others typologies tables
                'create_sp_produto_typology_attributes_table',
                'create_sp_produto_units_table',
                'create_sp_produto_documents_table',
                'create_sp_produto_media_table',
            ])
            ->runsMigrations();

        $package
            ->name('sp-produto')
            ->hasCommands([
                InstallSp::class
            ]);
    }
}

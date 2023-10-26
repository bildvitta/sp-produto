<?php

namespace BildVitta\SpProduto;

use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\RealEstateDevelopmentImportCommand;
use BildVitta\SpProduto\Console\Commands\Messages\RealEstateDevelopmentWorkerCommand;
use BildVitta\SpProduto\Console\ConfigSp;
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
     * @var array $migrations
     */
    protected array $migrations = [
        'create_workers_table',
        'create_sp_produto_real_estate_developments_table', // must be the first
        'create_sp_produto_buying_options_table', // must be before others buying options tables
        'create_sp_produto_buying_option_real_estate_development_table',
        'create_sp_produto_parameters_table',
        'create_sp_produto_insurance_companies_table', // must be before others insurance tables
        'create_sp_produto_insurances_table',
        'create_sp_produto_insurance_company_real_estate_development_table',
        'create_sp_produto_insurance_real_estate_development_table',
        'create_sp_produto_accessory_categories_table', // must be before the accessories table
        'create_sp_produto_accessories_table',
        'create_sp_produto_mirrors_table', // must be before the mirrors table
        'create_sp_produto_mirror_groups_table',
        'create_sp_produto_blueprints', // must be before others blueprints tables
        'create_sp_produto_blueprint_images_table',
        'create_sp_produto_blueprint_real_estate_development_accessory_table',
        'create_sp_produto_blueprint_typology_table',
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
        'create_sp_produto_stage_images_table',
        'add_foreign_keys_to_sp_produto_blueprint_real_estate_development_accessory_table',
        'add_foreign_keys_to_sp_produto_blueprint_typology_table',
        'add_foreign_keys_to_sp_produto_buying_option_real_estate_development_table',
        'add_foreign_keys_to_sp_produto_insurance_company_real_estate_development_table',
        'add_foreign_keys_to_sp_produto_proposal_model_real_estate_development_table',
        'add_foreign_keys_to_sp_produto_proposal_model_typology_table',
        'add_foreign_keys_to_sp_produto_real_estate_development_accessories_table',
        'add_table_price_to_sp_produto_units_table',
        'add_verge_percentages_to_sp_produto_parameters_table',
    ];

    /**
     * @var array $commands
     */
    protected array $commands = [
        ConfigSp::class,
        InstallSp::class,
        RealEstateDevelopmentImportCommand::class,
        RealEstateDevelopmentWorkerCommand::class,
    ];

    /**
     * @var string $seeder
     */
    protected string $seeder = 'SpProdutoSeeder';

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
            ->hasMigrations($this->getMigrations())
            ->runsMigrations();

        $package
            ->name('sp-produto')
            ->hasCommands($this->commands);

        $this->publishes([
            $package->basePath("/../database/seeders/{$this->seeder}.php.stub")
            => database_path("seeders/{$this->seeder}.php")
        ], 'seeders');
    }

    /**
     * @return array
     */
    private function getMigrations(): array
    {
        $relations = config('sp-produto.sync_relations');
        if (is_null($relations)) {
            return $this->migrations;
        }
        $migrations = [
            'create_workers_table',
            'create_sp_produto_real_estate_developments_table'
        ];
        foreach ($relations as $relation) {
            switch ($relation) {
                case 'buying_options':
                    $migrations[] = 'create_sp_produto_buying_options_table';
                    $migrations[] = 'create_sp_produto_buying_option_real_estate_development_table';
                    $migrations[] = 'add_foreign_keys_to_sp_produto_buying_option_real_estate_development_table';
                    break;
                case 'parameters':
                    $migrations[] = 'create_sp_produto_parameters_table';
                    $migrations[] = 'add_verge_percentages_to_sp_produto_parameters_table';
                    break;
                case 'insurances':
                    $migrations[] = 'create_sp_produto_insurance_companies_table';
                    $migrations[] = 'create_sp_produto_insurances_table';
                    $migrations[] = 'create_sp_produto_insurance_company_real_estate_development_table';
                    $migrations[] = 'create_sp_produto_insurance_real_estate_development_table';
                    $migrations[] = 'add_foreign_keys_to_sp_produto_insurance_company_real_estate_development_table';
                    break;
                case 'accessories':
                    $migrations[] = 'create_sp_produto_accessory_categories_table';
                    $migrations[] = 'create_sp_produto_accessories_table';
                    $migrations[] = 'create_sp_produto_real_estate_development_accessories_table';
                    $migrations[] = 'add_foreign_keys_to_sp_produto_real_estate_development_accessories_table';
                    break;
                case 'mirrors':
                    $migrations[] = 'create_sp_produto_mirrors_table';
                    $migrations[] = 'create_sp_produto_mirror_groups_table';
                    break;
                case 'blueprints':
                    $migrations[] = 'create_sp_produto_blueprints';
                    $migrations[] = 'create_sp_produto_blueprint_images_table';
                    $migrations[] = 'create_sp_produto_blueprint_real_estate_development_accessory_table';
                    $migrations[] = 'create_sp_produto_blueprint_typology_table';
                    $migrations[] = 'add_foreign_keys_to_sp_produto_blueprint_real_estate_development_accessory_table';
                    $migrations[] = 'add_foreign_keys_to_sp_produto_blueprint_typology_table';
                    break;
                case 'characteristics':
                    $migrations[] = 'create_sp_produto_characteristics_table';
                    $migrations[] = 'create_sp_produto_real_estate_development_characteristic_table';
                    break;
                case 'proposal_models':
                    $migrations[] = 'create_sp_produto_proposal_models_table';
                    $migrations[] = 'create_sp_produto_proposal_model_periodicities_table';
                    $migrations[] = 'create_sp_produto_proposal_model_real_estate_development_table';
                    $migrations[] = 'create_sp_produto_proposal_model_typology_table';
                    $migrations[] = 'add_foreign_keys_to_sp_produto_proposal_model_real_estate_development_table';
                    $migrations[] = 'add_foreign_keys_to_sp_produto_proposal_model_typology_table';
                    break;
                case 'stages':
                    $migrations[] = 'create_sp_produto_stages_table';
                    $migrations[] = 'create_sp_produto_stage_images_table';
                    break;
                case 'typologies':
                    $migrations[] = 'create_sp_produto_typologies_table';
                    $migrations[] = 'create_sp_produto_typology_attributes_table';
                    break;
                case 'units':
                    $migrations[] = 'create_sp_produto_units_table';
                    $migrations[] = 'add_table_price_to_sp_produto_units_table';
                    break;
                case 'documents':
                    $migrations[] = 'create_sp_produto_documents_table';
                    break;
                case 'media':
                    $migrations[] = 'create_sp_produto_media_table';
                    break;
            }
        }

        $migrations[] = 'create_sp_produto_real_estate_development_companies_table';

        return $migrations;
    }
}

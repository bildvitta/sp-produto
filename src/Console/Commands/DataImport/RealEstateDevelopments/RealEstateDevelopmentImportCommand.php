<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments;

use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Jobs\RealEstateDevelopmentImportJob;
use Illuminate\Console\Command;

class RealEstateDevelopmentImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataimport:produto_real_estate_developments {--select=500} {--offset=0} {--table=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call init sync real estate developments in database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting import');
        
        if (! class_exists('\App\Models\Worker')) {
            $this->info('Error: class \App\Models\Worker not exists');
            return 1;
        }

        $selectLimit = 500;
        if ($optionSelect = $this->option('select')) {
            $selectLimit = (int) $optionSelect;
        }

        $offset = 0;
        if ($optionOffset = $this->option('offset')) {
            $offset = (int) $optionOffset;
        }
        
        $tableIndex = 0;
        if ($optionTableIndex = $this->option('table')) {
            $tableIndex = (int) $optionTableIndex;
        }

        $worker = new \App\Models\Worker();
        $worker->type = 'sp-produto.dataimport.real_estate_developments';
        $worker->status = 'created';
        $worker->schedule = now();
        $worker->payload = [
            'limit' => $selectLimit,
            'offset' => $offset,
            'total' => null,
            'table_index' => $tableIndex,
            'tables' => [
                0 => 'hub_companies',
                1 => 'accessory_categories',
                2 => 'accessories',
                3 => 'characteristics',
                4 => 'proposal_models',
                5 => 'proposal_model_periodicities',
                6 => 'buying_options',
                7 => 'insurance_companies',
                8 => 'insurances',
                9 => 'real_estate_developments',
                10 => 'proposal_model_real_estate_development',
                11 => 'buying_option_real_estate_development',
                12 => 'insurance_company_real_estate_development',
                13 => 'insurance_real_estate_development',
                14 => 'characteristic_real_estate_development',
                15 => 'typologies',
                16 => 'real_estate_development_accessories',
                17 => 'parameters',
                18 => 'mirrors',
                19 => 'mirror_groups',
                20 => 'blueprints',
                21 => 'blueprint_images',
                22 => 'blueprint_typology',
                23 => 'proposal_model_typology',
                24 => 'real_estate_development_accessory_blueprint',
                25 => 'units',
                26 => 'documents',
                27 => 'stages',
                28 => 'stage_images',
                29 => 'media',
            ],
        ];
        $worker->save();

        RealEstateDevelopmentImportJob::dispatch($worker->id);

        $this->info('Worker type: sp-produto.dataimport.real_estate_developments');
        $this->info('Job started, command execution ended');

        return 0;
    }
}

<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments;

use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Jobs\RealEstateDevelopmentImportJob;
use BildVitta\SpProduto\Models\Worker;
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

        $worker = new Worker;
        $worker->type = 'sp-produto.dataimport.real_estate_developments';
        $worker->status = 'created';
        $worker->queue = 'default';
        $worker->schedule = now();
        $worker->payload = [
            'limit' => $selectLimit,
            'offset' => $offset,
            'total' => null,
            'table_index' => $tableIndex,
            'tables' => $this->getTables(),
        ];
        $worker->save();

        RealEstateDevelopmentImportJob::dispatch($worker->id);

        $this->info('Worker type: sp-produto.dataimport.real_estate_developments');
        $this->info('Job started, command execution ended');

        return 0;
    }

    private function configHas(string $relation): bool
    {
        $syncRelations = config('sp-produto.sync_relations');
        if (is_array($syncRelations)) {
            return in_array($relation, $syncRelations);
        }

        return false;
    }

    private function getTables(): array
    {
        $tables = [];
        if ($this->configHas('accessories')) {
            $tables[] = 'accessory_categories';
            $tables[] = 'accessories';
        }
        if ($this->configHas('characteristics')) {
            $tables[] = 'characteristics';
        }
        if ($this->configHas('proposal_models')) {
            $tables[] = 'proposal_models';
            $tables[] = 'proposal_model_periodicities';
        }
        if ($this->configHas('buying_options')) {
            $tables[] = 'buying_options';
        }
        if ($this->configHas('insurances')) {
            $tables[] = 'insurance_companies';
            $tables[] = 'insurances';
        }

        $tables[] = 'real_estate_developments';

        if ($this->configHas('proposal_models')) {
            $tables[] = 'proposal_model_real_estate_development';
        }
        if ($this->configHas('buying_options')) {
            $tables[] = 'buying_option_real_estate_development';
        }
        if ($this->configHas('insurances')) {
            $tables[] = 'insurance_company_real_estate_development';
            $tables[] = 'insurance_real_estate_development';
        }
        if ($this->configHas('characteristics')) {
            $tables[] = 'characteristic_real_estate_development';
        }
        if ($this->configHas('typologies')) {
            $tables[] = 'typologies';
        }
        if ($this->configHas('accessories')) {
            $tables[] = 'real_estate_development_accessories';
        }
        if ($this->configHas('parameters')) {
            $tables[] = 'parameters';
        }
        if ($this->configHas('mirrors')) {
            $tables[] = 'mirrors';
            $tables[] = 'mirror_groups';
        }
        if ($this->configHas('blueprints')) {
            $tables[] = 'blueprints';
            $tables[] = 'blueprint_images';
            $tables[] = 'blueprint_typology';
        }
        if ($this->configHas('proposal_models')) {
            $tables[] = 'proposal_model_typology';
        }
        if ($this->configHas('blueprints')) {
            $tables[] = 'real_estate_development_accessory_blueprint';
        }
        if ($this->configHas('units')) {
            $tables[] = 'units';
            $tables[] = 'units_accessories';
            $tables[] = 'units_prices';
        }
        if ($this->configHas('documents')) {
            $tables[] = 'documents';
        }
        if ($this->configHas('stages')) {
            $tables[] = 'stages';
            $tables[] = 'stage_images';
        }
        if ($this->configHas('media')) {
            $tables[] = 'media';
        }
        if ($this->configHas('personalizations')) {
            $tables[] = 'environments';
            $tables[] = 'personalizations';
        }
        return $tables;
    }
}

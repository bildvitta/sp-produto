<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\Properties;

use BildVitta\SpProduto\Console\Commands\DataImport\Properties\Jobs\PropertyImportJob;
use BildVitta\SpProduto\Models\Worker;
use Illuminate\Console\Command;

class PropertiesImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataimport:produto_properties {--select=500} {--offset=0} {--table=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call init sync properties in database';

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

        $worker = new Worker();
        $worker->type = 'sp-produto.dataimport.properties';
        $worker->status = 'created';
        $worker->schedule = now();
        $worker->payload = [
            'limit' => $selectLimit,
            'offset' => $offset,
            'total' => null,
            'table_index' => $tableIndex,
            'tables' => $this->getTables(),
        ];
        $worker->save();

        PropertyImportJob::dispatch($worker->id);

        $this->info('Worker type: sp-produto.dataimport.properties');
        $this->info('Job started, command execution ended');

        return Command::SUCCESS;
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
        if ($this->configHas('properties')) {
            $tables[] = 'automobile_brands';
            $tables[] = 'automobile_models';
            $tables[] = 'automobile_versions';
            $tables[] = 'automobile_differentials';
            $tables[] = 'estate_differentials';
            $tables[] = 'properties';
            $tables[] = 'property_attachments';
            $tables[] = 'holder_property';
            $tables[] = 'property_images';
            $tables[] = 'automobile_differential_property';
            $tables[] = 'estate_differential_property';
        }

        return $tables;
    }
}

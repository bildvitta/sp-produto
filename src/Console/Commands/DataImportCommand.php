<?php

namespace BildVitta\SpProduto\Console\Commands;

use App\Models\HubCompany;
use BildVitta\SpProduto\Models\Accessory;
use BildVitta\SpProduto\Models\AccessoryCategory;
use BildVitta\SpProduto\Models\BuyingOption;
use BildVitta\SpProduto\Models\Insurance;
use BildVitta\SpProduto\Models\InsuranceCompany;
use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DataImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataimport:produto_real_estate_developments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call init sync real estate developments in database';

    private int $selectLimit = 300;

    /**
     * List of entities to sync.
     *
     * @var string[] $sync
     */
    protected $sync = [
        'hub_companies',
        'accessory_categories',
        'accessories',
        'proposal_models',
        'buying_options',
        'insurance_companies',
        'insurances',
        'real_estate_developments',
        'proposal_model_real_estate_development',
        'buying_option_real_estate_development',
        'insurance_company_real_estate_development',
        'insurance_real_estate_development',
        'typologies',
        'real_estate_development_accessories',
        'mirrors',
        'mirror_groups',
        'blueprints',
        'units',
        'documents',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting import');

        $this->configConnection();
        $database = DB::connection('produto');

        // Sync Hub Companies
        if (in_array('hub_companies', $this->sync)) {
            $hub_companies = $database->table('hub_companies')
                ->whereNull('deleted_at')
                ->get();

            $this->syncData(
                $hub_companies,
                HubCompany::class,
                'Hub companies'
            );
        }

        // Sync Accessories Categories
        if (in_array('accessory_categories', $this->sync)) {
            $accessoryCategories = $database->table('categories as ca')
                ->leftJoin('hub_companies as hc', 'ca.hub_company_id', '=', 'hc.id')
                ->select('ca.*', 'hc.uuid as hub_company_uuid')
                ->whereNull('ca.deleted_at')
                ->get();

            $this->syncData(
                $accessoryCategories,
                AccessoryCategory::class,
                'Accessory Categories',
                ['hub_company' => HubCompany::class]
            );
        }

        // Sync Accessories
        if (in_array('accessories', $this->sync)) {
            $accessories = $database->table('accessories as ac')
                ->leftJoin('hub_companies as hc', 'ac.hub_company_id', '=', 'hc.id')
                ->leftJoin('categories as ca', 'ac.category_id', '=', 'ca.id')
                ->select('ac.*', 'hc.uuid as hub_company_uuid', 'ac.uuid as category_uuid')
                ->whereNull('ac.deleted_at')
                ->get();

            $this->syncData(
                $accessories,
                Accessory::class,
                'Accessories',
                [
                    'hub_company' => HubCompany::class,
                    'category' => AccessoryCategory::class,
                ]
            );
        }

        // Sync Proposal Models
        if (in_array('proposal_models', $this->sync)) {
            $proposalModels = $database->table('proposal_models as pm')
                ->leftJoin('hub_companies as hc', 'pm.hub_company_id', '=', 'hc.id')
                ->select('pm.*', 'hc.uuid as hub_company_uuid')
                ->whereNull('pm.deleted_at')
                ->get();

            $this->syncData(
                $proposalModels,
                ProposalModel::class,
                'Proposal Models',
                ['hub_company' => HubCompany::class]
            );
        }

        // Sync Buying Options
        if (in_array('buying_options', $this->sync)) {
            $buyingOptions = $database->table('buying_options as bo')
                ->leftJoin('hub_companies as hc', 'bo.hub_company_id', '=', 'hc.id')
                ->select('bo.*', 'hc.uuid as hub_company_uuid')
                ->whereNull('bo.deleted_at')
                ->get();

            $this->syncData(
                $buyingOptions,
                BuyingOption::class,
                'Buying Options',
                ['hub_company' => HubCompany::class]
            );
        }

        // Sync Insurance Companies
        if (in_array('insurance_companies', $this->sync)) {
            $insuranceCompanies = $database->table('insurance_companies as ic')
                ->leftJoin('hub_companies as hc', 'ic.hub_company_id', '=', 'hc.id')
                ->select('ic.*', 'hc.uuid as hub_company_uuid')
                ->whereNull('ic.deleted_at')
                ->get();

            $this->syncData(
                $insuranceCompanies,
                InsuranceCompany::class,
                'Insurance Companies',
                ['hub_company' => HubCompany::class]
            );
        }

        // Sync Insurances
        if (in_array('insurances', $this->sync)) {
            $insurances = $database->table('insurances as in')
                ->leftJoin('insurance_companies as ic', 'in.insurance_company_id', '=', 'ic.id')
                ->select('in.*', 'ic.uuid as insurance_company_uuid')
                ->whereNull('in.deleted_at')
                ->get();

            $this->syncData(
                $insurances,
                Insurance::class,
                'Insurances',
                ['insurance_company' => InsuranceCompany::class]
            );
        }

        // Sync Real Estate Developments
        if (in_array('real_estate_developments', $this->sync)) {
            $realEstateDevelopments = $database->table('real_estate_developments as red')
                ->leftJoin('hub_companies as hc', 'red.hub_company_id', '=', 'hc.id')
                ->select('red.*', 'hc.uuid as hub_company_uuid')
                ->whereNull('red.deleted_at')
                ->get();

            $this->syncData(
                $realEstateDevelopments,
                RealEstateDevelopment::class,
                'Real Estate Developments',
                ['hub_company' => HubCompany::class]
            );
        }

        // Sync Proposal Models with Real Estate Developments
        if (in_array('proposal_model_real_estate_development', $this->sync)) {
            $proposalModelRealEstateDevelopment = $database->table('proposal_model_real_estate_development as pr')
                ->leftJoin('proposal_models as pm', 'pr.proposal_model_id', '=', 'pm.id')
                ->leftJoin('real_estate_developments as red', 'pr.real_estate_development_id', '=', 'red.id')
                ->select('pm.uuid as foreign_uuid', 'red.uuid as model_uuid')
                ->get();

            $this->syncRelated(
                $proposalModelRealEstateDevelopment,
                RealEstateDevelopment::class,
                ProposalModel::class,
                'proposal_models',
                'Proposal Models for Real Estate Developments'
            );
        }

        // Sync Buying Options with Real Estate Developments
        if (in_array('buying_option_real_estate_development', $this->sync)) {
            $buyingOptionRealEstateDevelopment = $database->table('buying_option_real_estate_development as br')
                ->leftJoin('buying_options as bo', 'br.buying_option_id', '=', 'bo.id')
                ->leftJoin('real_estate_developments as red', 'br.real_estate_development_id', '=', 'red.id')
                ->select('bo.uuid as foreign_uuid', 'red.uuid as model_uuid')
                ->get();

            $this->syncRelated(
                $buyingOptionRealEstateDevelopment,
                RealEstateDevelopment::class,
                BuyingOption::class,
                'buying_options',
                'Buying Options for Real Estate Developments'
            );
        }

        // Sync Insurance Companies with Real Estate Developments
        if (in_array('insurance_company_real_estate_development', $this->sync)) {
            $insuranceCompanyRealEstateDevelopment = $database->table('insurance_company_real_estate_development as icr')
                ->leftJoin('insurance_companies as ic', 'icr.insurance_company_id', '=', 'ic.id')
                ->leftJoin('real_estate_developments as red', 'icr.real_estate_development_id', '=', 'red.id')
                ->select('ic.uuid as foreign_uuid', 'red.uuid as model_uuid')
                ->get();

            $this->syncRelated(
                $insuranceCompanyRealEstateDevelopment,
                RealEstateDevelopment::class,
                InsuranceCompany::class,
                'insurance_companies',
                'Insurance Companies for Real Estate Developments'
            );
        }

        // Sync Insurances with Real Estate Developments
        if (in_array('insurance_real_estate_development', $this->sync)) {
            $insuranceRealEstateDevelopment = $database->table('insurance_real_estate_development as ir')
                ->leftJoin('insurances as in', 'ir.insurance_id', '=', 'in.id')
                ->leftJoin('real_estate_developments as red', 'ir.real_estate_development_id', '=', 'red.id')
                ->select('in.uuid as foreign_uuid', 'red.uuid as model_uuid')
                ->get();

            $this->syncRelated(
                $insuranceRealEstateDevelopment,
                RealEstateDevelopment::class,
                Insurance::class,
                'insurances',
                'Insurances for Real Estate Developments'
            );
        }

        // Sync Parameters

        // Sync Characteristics

        // Sync Typologies
        if (in_array('typologies', $this->sync)) {
            $typologies = $database->table('typologies as ty')
                ->leftJoin('real_estate_developments as red', 'ty.real_estate_development_id', '=', 'red.id')
                ->leftJoin('proposal_models as pm', 'ty.proposal_model_id', '=', 'pm.id')
                ->select('ty.*', 'red.uuid as real_estate_development_uuid', 'pm.uuid as proposal_model_uuid')
                ->whereNull('ty.deleted_at')
                ->get();

            $this->syncData(
                $typologies,
                RealEstateDevelopment\Typology::class,
                'Typologies',
                [
                    'real_estate_development' => RealEstateDevelopment::class,
                    'proposal_model' => ProposalModel::class,
                ]
            );
        }

        // Sync Accessories
        if (in_array('real_estate_development_accessories', $this->sync)) {
            $realEstateDevelopmentAccessories = $database->table('real_estate_development_accessories as ra')
                ->leftJoin('real_estate_developments as red', 'ra.real_estate_development_id', '=', 'red.id')
                ->leftJoin('categories as ca', 'ra.category_id', '=', 'ca.id')
                ->select('ra.*', 'red.uuid as real_estate_development_uuid', 'ca.uuid as accessory_category_uuid')
                ->whereNull('ra.deleted_at')
                ->get();

            $this->syncData(
                $realEstateDevelopmentAccessories,
                RealEstateDevelopment\Accessory::class,
                'Accessories for Real Estate Development',
                [
                    'real_estate_development' => RealEstateDevelopment::class,
                    'accessory_category' => AccessoryCategory::class,
                ]
            );
        }

        // Sync Mirrors
        if (in_array('mirrors', $this->sync)) {
            $mirrors = $database->table('mirrors as mi')
                ->leftJoin('real_estate_developments as red', 'mi.real_estate_development_id', '=', 'red.id')
                ->select('mi.*', 'red.uuid as real_estate_development_uuid')
                ->whereNull('mi.deleted_at')
                ->get();

            $this->syncData(
                $mirrors,
                RealEstateDevelopment\Mirror::class,
                'Mirrors for Real Estate Development',
                ['real_estate_development' => RealEstateDevelopment::class]
            );
        }

        // Sync Mirror Groups
        if (in_array('mirror_groups', $this->sync)) {
            $mirrorGroups = $database->table('mirror_groups as mg')
                ->leftJoin('mirrors as mi', 'mg.mirror_id', '=', 'mi.id')
                ->select('mg.*', 'mi.uuid as mirror_uuid')
                ->whereNull('mg.deleted_at')
                ->get();

            $this->syncData(
                $mirrorGroups,
                RealEstateDevelopment\MirrorGroup::class,
                'Mirror Groups for Real Estate Development',
                ['mirror' => RealEstateDevelopment\Mirror::class]
            );
        }

        // Sync Blueprints
        if (in_array('blueprints', $this->sync)) {
            $blueprints = $database->table('blueprints as bl')
                ->leftJoin('real_estate_developments as red', 'bl.real_estate_development_id', '=', 'red.id')
                ->select('bl.*', 'red.uuid as real_estate_development_uuid')
                ->whereNull('bl.deleted_at')
                ->get();

            $this->syncData(
                $blueprints,
                RealEstateDevelopment\Blueprint::class,
                'Blueprints for Real Estate Development',
                ['real_estate_development' => RealEstateDevelopment::class]
            );
        }

        // Sync Units
        if (in_array('units', $this->sync)) {
            $units = $database->table('units as un')
                ->leftJoin('real_estate_developments as red', 'un.real_estate_development_id', '=', 'red.id')
                ->leftJoin('typologies as ty', 'un.typology_id', '=', 'ty.id')
                ->leftJoin('mirrors as mi', 'un.mirror_id', '=', 'mi.id')
                ->leftJoin('mirror_groups as mg', 'un.mirror_group_id', '=', 'mg.id')
                ->leftJoin('blueprints as bp', 'un.blueprint_id', '=', 'bp.id')
                ->select(
                    'un.*',
                    'red.uuid as real_estate_development_uuid',
                    'ty.uuid as typology_uuid',
                    'mi.uuid as mirror_uuid',
                    'mg.uuid as mirror_group_uuid',
                    'bp.uuid as blueprint_uuid',
                )
                ->whereNull('un.deleted_at')
                ->get();

            $this->syncData(
                $units,
                RealEstateDevelopment\Unit::class,
                'Units for Real Estate Development',
                [
                    'real_estate_development' => RealEstateDevelopment::class,
                    'typology' => RealEstateDevelopment\Typology::class,
                    'mirror' => RealEstateDevelopment\Mirror::class,
                    'mirror_group' => RealEstateDevelopment\MirrorGroup::class,
                    'blueprint' => RealEstateDevelopment\Blueprint::class,
                ],
                ['ready_to_live_in']
            );
        }

        // Sync Documents
        if (in_array('documents', $this->sync)) {
            $documents = $database->table('documents as dc')
                ->leftJoin('real_estate_developments as red', 'dc.real_estate_development_id', '=', 'red.id')
                ->select('dc.*', 'red.uuid as real_estate_development_uuid')
                ->whereNull('dc.deleted_at')
                ->get();

            $this->syncData(
                $documents,
                RealEstateDevelopment\Document::class,
                'Documents for Real Estate Development',
                ['real_estate_development' => RealEstateDevelopment::class]
            );
        }

        // Sync Media

        // Sync Stages

        $this->newLine();
        $this->info('Import finished');

        return 0;
    }

    /**
     * @param Collection $query
     * @param string $model
     * @param string|null $label
     * @param array $related
     * @param array $dates
     * @return void
     */
    private function syncData(
        Collection $query,
        string $model,
        string $label = null,
        array $related = [],
        array $dates = []
    ): void {
        $totalRecords = $query->count();

        if ($totalRecords > 0) {
            $this->newLine();
            $this->info(sprintf('Importing %s...', $label));
            $bar = $this->output->createProgressBar($totalRecords);
            $bar->start();

            $query->each(function ($item) use ($model, $related, $dates, $bar) {
                foreach ($related as $name => $object) {
                    $relatedObject = $object::firstWhere('uuid', $item->{sprintf('%s_uuid', $name)});
                    $item->{sprintf('%s_id', $name)} = $relatedObject?->id;
                }

                foreach ($dates as $date) {
                    $item->{$date} = Carbon::parse($item->{$date}) === true ? $item->{$date} : null;
                }

                $model::updateOrCreate(
                    ['uuid' => $item->uuid],
                    collect($item)->toArray()
                );

                $bar->advance(1);
            });

            $bar->finish();
            $this->newLine();
            $result = $model::whereNull('deleted_at')->count();
            $this->info(sprintf('Imported %s of %s registers.', $result, $totalRecords));
        }
    }

    /**
     * @param Collection $query
     * @param string $model
     * @param string $foreign
     * @param string $method
     * @param string $label
     * @return void
     */
    private function syncRelated(Collection $query, string $model, string $foreign, string $method, string $label): void
    {
        $totalRecords = $query->count();
        if ($totalRecords > 0) {
            $this->newLine();
            $this->info(sprintf('Synchronizing %s...', $label));
            $bar = $this->output->createProgressBar($totalRecords);
            $bar->start();

            $query->each(function ($item) use ($model, $foreign, $method, $bar) {
                $modelObject = $model::firstWhere('uuid', $item->model_uuid);
                $foreignObject = $foreign::firstWhere('uuid', $item->foreign_uuid);

                if ($modelObject) {
                    $modelObject->{$method}()->sync($foreignObject);
                }

                $bar->advance(1);
            });

            $bar->finish();
            $this->newLine();
            $result = $model::whereNull('deleted_at')->count();
            $this->info(sprintf('Synced %s of %s registers.', $result, $totalRecords));
        }
    }

    /**
     * @return void
     */
    private function configConnection(): void
    {
        config([
            'database.connections.produto' => [
                'driver' => 'mysql',
                'host' => config('sp-produto.db.host'),
                'port' => config('sp-produto.db.port'),
                'database' => config('sp-produto.db.database'),
                'username' => config('sp-produto.db.username'),
                'password' => config('sp-produto.db.password'),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => [],
            ]
        ]);
    }
}

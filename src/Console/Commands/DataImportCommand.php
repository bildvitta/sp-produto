<?php

namespace BildVitta\SpProduto\Console\Commands;

use App\Models\HubCompany;
use BildVitta\SpProduto\Models\Accessory;
use BildVitta\SpProduto\Models\AccessoryCategory;
use BildVitta\SpProduto\Models\BuyingOption;
use BildVitta\SpProduto\Models\Characteristic;
use BildVitta\SpProduto\Models\Insurance;
use BildVitta\SpProduto\Models\InsuranceCompany;
use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\ProposalModelPeriodicities;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
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
     * List of entities to sync.
     *
     * @var string[] $sync
     */
    protected $sync = [
        'hub_companies',
        'accessory_categories',
        'accessories',
        'characteristics',
        'proposal_models',
        'proposal_model_periodicities',
        'buying_options',
        'insurance_companies',
        'insurances',
        'real_estate_developments',
        'proposal_model_real_estate_development',
        'buying_option_real_estate_development',
        'insurance_company_real_estate_development',
        'insurance_real_estate_development',
        'characteristic_real_estate_development',
        'typologies',
        'real_estate_development_accessories',
        'parameters',
        'mirrors',
        'mirror_groups',
        'blueprints',
        'blueprint_images',
        'blueprint_typology',
        'proposal_model_typology',
        'real_estate_development_accessory_blueprint',
        'units',
        'documents',
        'stages',
        'stage_images',
        'media',
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call init sync real estate developments in database';

    private int $selectLimit = 300;

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
            $hub_companies = $database->table('hub_companies');

            $this->syncData(
                $hub_companies,
                HubCompany::class,
                'Hub companies',
                [],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Accessories Categories
        if (in_array('accessory_categories', $this->sync)) {
            $accessoryCategories = $database->table('categories as ca')
                ->leftJoin('hub_companies as hc', 'ca.hub_company_id', '=', 'hc.id')
                ->select('ca.*', 'hc.uuid as hub_company_uuid');

            $this->syncData(
                $accessoryCategories,
                AccessoryCategory::class,
                'Accessory Categories',
                ['hub_company' => HubCompany::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Accessories
        if (in_array('accessories', $this->sync)) {
            $accessories = $database->table('accessories as ac')
                ->leftJoin('hub_companies as hc', 'ac.hub_company_id', '=', 'hc.id')
                ->leftJoin('categories as ca', 'ac.category_id', '=', 'ca.id')
                ->select('ac.*', 'hc.uuid as hub_company_uuid', 'ac.uuid as category_uuid');

            $this->syncData(
                $accessories,
                Accessory::class,
                'Accessories',
                [
                    'hub_company' => HubCompany::class,
                    'category' => AccessoryCategory::class,
                ],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Characteristics
        if (in_array('characteristics', $this->sync)) {
            $characteristics = $database->table('characteristics as ch')
                ->leftJoin('hub_companies as hc', 'ch.hub_company_id', '=', 'hc.id')
                ->select('ch.*', 'hc.uuid as hub_company_uuid');

            $this->syncData(
                $characteristics,
                Characteristic::class,
                'Characteristics',
                ['hub_company' => HubCompany::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Proposal Models
        if (in_array('proposal_models', $this->sync)) {
            $proposalModels = $database->table('proposal_models as pm')
                ->leftJoin('hub_companies as hc', 'pm.hub_company_id', '=', 'hc.id')
                ->select('pm.*', 'hc.uuid as hub_company_uuid');

            $this->syncData(
                $proposalModels,
                ProposalModel::class,
                'Proposal Models',
                ['hub_company' => HubCompany::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Proposal Models Periodicities
        if (in_array('proposal_model_periodicities', $this->sync)) {
            $proposalModelsPeriodicities = $database->table('proposal_model_periodicities as pp')
                ->leftJoin('proposal_models as pm', 'pp.proposal_model_id', '=', 'pm.id')
                ->select('pp.*', 'pm.uuid as proposal_model_uuid');

            $this->syncData(
                $proposalModelsPeriodicities,
                ProposalModelPeriodicities::class,
                'Proposal Models Periodicities',
                ['proposal_model' => ProposalModel::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Buying Options
        if (in_array('buying_options', $this->sync)) {
            $buyingOptions = $database->table('buying_options as bo')
                ->leftJoin('hub_companies as hc', 'bo.hub_company_id', '=', 'hc.id')
                ->select('bo.*', 'hc.uuid as hub_company_uuid');

            $this->syncData(
                $buyingOptions,
                BuyingOption::class,
                'Buying Options',
                ['hub_company' => HubCompany::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Insurance Companies
        if (in_array('insurance_companies', $this->sync)) {
            $insuranceCompanies = $database->table('insurance_companies as ic')
                ->leftJoin('hub_companies as hc', 'ic.hub_company_id', '=', 'hc.id')
                ->select('ic.*', 'hc.uuid as hub_company_uuid');

            $this->syncData(
                $insuranceCompanies,
                InsuranceCompany::class,
                'Insurance Companies',
                ['hub_company' => HubCompany::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Insurances
        if (in_array('insurances', $this->sync)) {
            $insurances = $database->table('insurances as i')
                ->leftJoin('insurance_companies as ic', 'i.insurance_company_id', '=', 'ic.id')
                ->select('i.*', 'ic.uuid as insurance_company_uuid');

            $this->syncData(
                $insurances,
                Insurance::class,
                'Insurances',
                ['insurance_company' => InsuranceCompany::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Real Estate Developments
        if (in_array('real_estate_developments', $this->sync)) {
            $realEstateDevelopments = $database->table('real_estate_developments as red')
                ->leftJoin('hub_companies as hc', 'red.hub_company_id', '=', 'hc.id')
                ->select('red.*', 'hc.uuid as hub_company_uuid');

            $this->syncData(
                $realEstateDevelopments,
                RealEstateDevelopment::class,
                'Real Estate Developments',
                ['hub_company' => HubCompany::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Proposal Models with Real Estate Developments
        if (in_array('proposal_model_real_estate_development', $this->sync)) {
            $proposalModelRealEstateDevelopment = $database->table('proposal_model_real_estate_development as pr')
                ->leftJoin('proposal_models as pm', 'pr.proposal_model_id', '=', 'pm.id')
                ->leftJoin('real_estate_developments as red', 'pr.real_estate_development_id', '=', 'red.id')
                ->select('pm.uuid as foreign_uuid', 'red.uuid as model_uuid');

            $this->syncRelated(
                $proposalModelRealEstateDevelopment,
                [
                    'class' => RealEstateDevelopment::class,
                    'field' => 'real_estate_development',
                ],
                [
                    'class' => ProposalModel::class,
                    'field' => 'proposal_model',
                ],
                'proposal_model_real_estate_development',
                'Proposal Models for Real Estate Developments'
            );
        }

        // Sync Buying Options with Real Estate Developments
        if (in_array('buying_option_real_estate_development', $this->sync)) {
            $buyingOptionRealEstateDevelopment = $database->table('buying_option_real_estate_development as br')
                ->leftJoin('buying_options as bo', 'br.buying_option_id', '=', 'bo.id')
                ->leftJoin('real_estate_developments as red', 'br.real_estate_development_id', '=', 'red.id')
                ->select('bo.uuid as foreign_uuid', 'red.uuid as model_uuid');

            $this->syncRelated(
                $buyingOptionRealEstateDevelopment,
                [
                    'class' => RealEstateDevelopment::class,
                    'field' => 'real_estate_development',
                ],
                [
                    'class' => BuyingOption::class,
                    'field' => 'buying_option',
                ],
                'buying_option_real_estate_development',
                'Buying Options for Real Estate Developments'
            );
        }

        // Sync Insurance Companies with Real Estate Developments
        if (in_array('insurance_company_real_estate_development', $this->sync)) {
            $insuranceCompanyRealEstateDevelopment = $database->table('insurance_company_real_estate_development as icr')
                ->leftJoin('insurance_companies as ic', 'icr.insurance_company_id', '=', 'ic.id')
                ->leftJoin('real_estate_developments as red', 'icr.real_estate_development_id', '=', 'red.id')
                ->select('ic.uuid as foreign_uuid', 'red.uuid as model_uuid');

            $this->syncRelated(
                $insuranceCompanyRealEstateDevelopment,
                [
                    'class' => RealEstateDevelopment::class,
                    'field' => 'real_estate_development',
                ],
                [
                    'class' => InsuranceCompany::class,
                    'field' => 'insurance_company',
                ],
                'insurance_company_real_estate_development',
                'Insurance Companies for Real Estate Developments'
            );
        }

        // Sync Insurances with Real Estate Developments
        if (in_array('insurance_real_estate_development', $this->sync)) {
            $insuranceRealEstateDevelopment = $database->table('insurance_real_estate_development as ir')
                ->leftJoin('insurances as in', 'ir.insurance_id', '=', 'in.id')
                ->leftJoin('real_estate_developments as red', 'ir.real_estate_development_id', '=', 'red.id')
                ->select('in.uuid as foreign_uuid', 'red.uuid as model_uuid');

            $this->syncRelated(
                $insuranceRealEstateDevelopment,
                [
                    'class' => RealEstateDevelopment::class,
                    'field' => 'real_estate_development',
                ],
                [
                    'class' => Insurance::class,
                    'field' => 'insurance',
                ],
                'insurance_real_estate_development',
                'Insurances for Real Estate Developments'
            );
        }

        // Sync Characteristics with Real Estate Developments
        if (in_array('characteristic_real_estate_development', $this->sync)) {
            $realEstateDevelopmentCharacteristic = $database->table('real_estate_development_characteristics as rc')
                ->leftJoin('characteristics as ch', 'rc.characteristic_id', '=', 'ch.id')
                ->leftJoin('real_estate_developments as red', 'rc.real_estate_development_id', '=', 'red.id')
                ->select('rc.*', 'red.uuid as real_estate_development_uuid', 'ch.uuid as characteristic_uuid');

            $this->syncData(
                $realEstateDevelopmentCharacteristic,
                RealEstateDevelopment\Characteristic::class,
                'Characteristics',
                [
                    'real_estate_development' => RealEstateDevelopment::class,
                    'characteristic' => Characteristic::class,
                ],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Typologies
        if (in_array('typologies', $this->sync)) {
            $typologies = $database->table('typologies as ty')
                ->leftJoin('real_estate_developments as red', 'ty.real_estate_development_id', '=', 'red.id')
                ->leftJoin('proposal_models as pm', 'ty.proposal_model_id', '=', 'pm.id')
                ->select('ty.*', 'red.uuid as real_estate_development_uuid', 'pm.uuid as proposal_model_uuid');

            $this->syncData(
                $typologies,
                RealEstateDevelopment\Typology::class,
                'Typologies',
                [
                    'real_estate_development' => RealEstateDevelopment::class,
                    'proposal_model' => ProposalModel::class,
                ],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Accessories
        if (in_array('real_estate_development_accessories', $this->sync)) {
            $realEstateDevelopmentAccessories = $database->table('real_estate_development_accessories as ra')
                ->leftJoin('real_estate_developments as red', 'ra.real_estate_development_id', '=', 'red.id')
                ->leftJoin('categories as ca', 'ra.category_id', '=', 'ca.id')
                ->select('ra.*', 'red.uuid as real_estate_development_uuid', 'ca.uuid as accessory_category_uuid');

            $this->syncData(
                $realEstateDevelopmentAccessories,
                RealEstateDevelopment\Accessory::class,
                'Accessories for Real Estate Development',
                [
                    'real_estate_development' => RealEstateDevelopment::class,
                    'accessory_category' => AccessoryCategory::class,
                ],
                ['created_at', 'updated_at', 'deleted_at', 'start_at', 'end_at']
            );
        }

        // Sync Parameters
        if (in_array('parameters', $this->sync)) {
            $parameters = $database->table('parameters as pa')
                ->leftJoin('real_estate_developments as red', 'pa.real_estate_development_id', '=', 'red.id')
                ->leftJoin('buying_options as bo', 'pa.buying_option_id', '=', 'bo.id')
                ->select('pa.*', 'red.uuid as real_estate_development_uuid', 'bo.uuid as buying_option_uuid');

            $this->syncData(
                $parameters,
                RealEstateDevelopment\Parameter::class,
                'Parameters',
                [
                    'real_estate_development' => RealEstateDevelopment::class,
                    'buying_option' => BuyingOption::class,
                ],
                [
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'blueprint_definition_deadline',
                    'construction_over_in',
                    'construction_prevision_in',
                    'construction_start_in',
                    'financial_transfer_deadline',
                    'hand_over_keys_in',
                    'launch_in',
                    'pre_launch_in',
                    'ready_to_live_in',
                ]
            );
        }

        // Sync Mirrors
        if (in_array('mirrors', $this->sync)) {
            $mirrors = $database->table('mirrors as mi')
                ->leftJoin('real_estate_developments as red', 'mi.real_estate_development_id', '=', 'red.id')
                ->leftJoin('parameters as pa', 'mi.parameter_id', '=', 'pa.id')
                ->select('mi.*', 'red.uuid as real_estate_development_uuid', 'pa.uuid as parameter_uuid');

            $this->syncData(
                $mirrors,
                RealEstateDevelopment\Mirror::class,
                'Mirrors for Real Estate Development',
                [
                    'real_estate_development' => RealEstateDevelopment::class,
                    'parameter' => RealEstateDevelopment\Parameter::class,
                ],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Mirror Groups
        if (in_array('mirror_groups', $this->sync)) {
            $mirrorGroups = $database->table('mirror_groups as mg')
                ->leftJoin('mirrors as mi', 'mg.mirror_id', '=', 'mi.id')
                ->select('mg.*', 'mi.uuid as mirror_uuid');

            $this->syncData(
                $mirrorGroups,
                RealEstateDevelopment\MirrorGroup::class,
                'Mirror Groups for Real Estate Development',
                ['mirror' => RealEstateDevelopment\Mirror::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Blueprints
        if (in_array('blueprints', $this->sync)) {
            $blueprints = $database->table('blueprints as bl')
                ->leftJoin('real_estate_developments as red', 'bl.real_estate_development_id', '=', 'red.id')
                ->select('bl.*', 'red.uuid as real_estate_development_uuid');

            $this->syncData(
                $blueprints,
                RealEstateDevelopment\Blueprint::class,
                'Blueprints for Real Estate Development',
                ['real_estate_development' => RealEstateDevelopment::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Blueprint Images
        if (in_array('blueprint_images', $this->sync)) {
            $blueprint_images = $database->table('blueprint_images as bi')
                ->leftJoin('blueprints as bp', 'bi.blueprint_id', '=', 'bp.id')
                ->select('bi.*', 'bp.uuid as blueprint_uuid');

            $this->syncData(
                $blueprint_images,
                RealEstateDevelopment\BlueprintImage::class,
                'Blueprint Imagess for Real Estate Development',
                ['blueprint' => RealEstateDevelopment\Blueprint::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Blueprint Typology
        if (in_array('blueprint_typology', $this->sync)) {
            $blueprint_typology = $database->table('blueprint_typology as bt')
                ->leftJoin('blueprints as bp', 'bt.blueprint_id', '=', 'bp.id')
                ->leftJoin('typologies as tp', 'bt.typology_id', '=', 'tp.id')
                ->select('bp.uuid as foreign_uuid', 'tp.uuid as model_uuid');

            $this->syncRelated(
                $blueprint_typology,
                [
                    'class' => RealEstateDevelopment\Typology::class,
                    'field' => 'typology',
                ],
                [
                    'class' => RealEstateDevelopment\Blueprint::class,
                    'field' => 'blueprint',
                ],
                'blueprint_typology',
                'Blueprint Typology'
            );
        }

        // Sync Proposal Model Typology
        if (in_array('proposal_model_typology', $this->sync)) {
            $proposal_model_typology = $database->table('proposal_model_typology as pt')
                ->leftJoin('proposal_models as pm', 'pt.proposal_model_id', '=', 'pm.id')
                ->leftJoin('typologies as tp', 'pt.typology_id', '=', 'tp.id')
                ->select('pm.uuid as foreign_uuid', 'tp.uuid as model_uuid');

            $this->syncRelated(
                $proposal_model_typology,
                [
                    'class' => RealEstateDevelopment\Typology::class,
                    'field' => 'typology',
                ],
                [
                    'class' => ProposalModel::class,
                    'field' => 'proposal_model',
                ],
                'proposal_model_typology',
                'Proposal Model Typology'
            );
        }

        // Sync Real Estate Developments Blueprints with Accessories
        if (in_array('real_estate_development_accessory_blueprint', $this->sync)) {
            $realEstateDevelopmentAccessoryBlueprint = $database->table('real_estate_development_accessory_blueprint as ab')
                ->leftJoin('blueprints as bp', 'ab.blueprint_id', '=', 'bp.id')
                ->leftJoin('real_estate_development_accessories as ra', 'ab.accessory_id', '=', 'ra.id')
                ->select('bp.uuid as foreign_uuid', 'ra.uuid as model_uuid');

            $this->syncRelated(
                $realEstateDevelopmentAccessoryBlueprint,
                [
                    'class' => RealEstateDevelopment\Accessory::class,
                    'field' => 'real_estate_development_accessory',
                ],
                [
                    'class' => RealEstateDevelopment\Blueprint::class,
                    'field' => 'blueprint',
                ],
                'blueprint_real_estate_development_accessory',
                'Real Estate Developments Accessory Blueprint'
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
                );

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
                ['created_at', 'updated_at', 'deleted_at', 'ready_to_live_in']
            );
        }

        // Sync Documents
        if (in_array('documents', $this->sync)) {
            $documents = $database->table('documents as dc')
                ->leftJoin('real_estate_developments as red', 'dc.real_estate_development_id', '=', 'red.id')
                ->select('dc.*', 'red.uuid as real_estate_development_uuid');

            $this->syncData(
                $documents,
                RealEstateDevelopment\Document::class,
                'Documents for Real Estate Development',
                ['real_estate_development' => RealEstateDevelopment::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Stages
        if (in_array('stages', $this->sync)) {
            $stages = $database->table('stages as st')
                ->leftJoin('real_estate_developments as red', 'st.real_estate_development_id', '=', 'red.id')
                ->select('st.*', 'red.uuid as real_estate_development_uuid');

            $this->syncData(
                $stages,
                RealEstateDevelopment\Stage::class,
                'Stages for Real Estate Development',
                ['real_estate_development' => RealEstateDevelopment::class],
                ['created_at', 'updated_at', 'deleted_at', 'registered_at']
            );
        }

        // Sync Stage Images
        if (in_array('stage_images', $this->sync)) {
            $stage_images = $database->table('stage_images as si')
                ->leftJoin('stages as s', 'si.stage_id', '=', 's.id')
                ->select('si.*', 's.uuid as stage_uuid');

            $this->syncData(
                $stage_images,
                RealEstateDevelopment\StageImage::class,
                'Stage Images for Real Estate Development',
                ['stage' => RealEstateDevelopment\Stage::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        // Sync Media
        if (in_array('media', $this->sync)) {
            $media = $database->table('media as md')
                ->leftJoin('real_estate_developments as red', 'md.real_estate_development_id', '=', 'red.id')
                ->select('md.*', 'red.uuid as real_estate_development_uuid');

            $this->syncData(
                $media,
                RealEstateDevelopment\Media::class,
                'Media for Real Estate Development',
                ['real_estate_development' => RealEstateDevelopment::class],
                ['created_at', 'updated_at', 'deleted_at']
            );
        }

        $this->newLine();
        $this->info('Import finished');

        return 0;
    }

    /**
     * @param Builder $query
     * @param string $model
     * @param string|null $label
     * @param array $related
     * @param array $dates
     * @return void
     */
    private function syncData(
        Builder $query,
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

            $loop = ceil($totalRecords / $this->selectLimit);
            for ($i = 0; $i < $loop; $i++) {
                $offset = $this->selectLimit * $i;

                $query->limit($this->selectLimit)->offset($offset);

                $query->get()->each(function ($item) use ($model, $related, $dates, $bar) {
                    foreach ($related as $name => $object) {
                        $relatedObject = $object::where('uuid', $item->{sprintf('%s_uuid', $name)});
                        if (in_array(SoftDeletes::class, class_uses($object))) {
                            $relatedObject->withTrashed();
                        }
                        $relatedObject = $relatedObject->first();
                        $item->{sprintf('%s_id', $name)} = $relatedObject?->id;
                    }

                    foreach ($dates as $date) {
                        $item->{$date} = Carbon::parse($item->{$date})->greaterThan('0001-01-01 23:59:59') ? $item->{$date} : null;
                    }

                    $newObj = $model::where('uuid', $item->uuid);

                    if (in_array(SoftDeletes::class, class_uses($model))) {
                        $newObj->withTrashed();
                    }

                    if (! $newObj = $newObj->first()) {
                        $newObj = new $model();
                    }

                    $newObj->fill(collect($item)->toArray());

                    $newObj->save();

                    $bar->advance(1);
                });
            }

            $bar->finish();
            $this->newLine();
            $result = $model::query();
            if (in_array(SoftDeletes::class, class_uses($model))) {
                $result->withTrashed();
            }
            $result = $result->count();
            $this->info(sprintf('Imported %s of %s registers.', $result, $totalRecords));
        }
    }

    /**
     * @param Builder $query
     * @param array $model
     * @param array $foreign
     * @param string $pivot
     * @param string $label
     * @return void
     */
    private function syncRelated(
        Builder $query,
        array $model,
        array $foreign,
        string $pivot,
        string $label
    ): void {
        $totalRecords = $query->count();
        if ($totalRecords > 0) {
            $this->newLine();
            $this->info(sprintf('Synchronizing %s...', $label));
            $bar = $this->output->createProgressBar($totalRecords);
            $bar->start();

            DB::table(prefixTableName($pivot))->delete();

            $loop = ceil($totalRecords / $this->selectLimit);
            for ($i = 0; $i < $loop; $i++) {
                $offset = $this->selectLimit * $i;

                $query->limit($this->selectLimit)->offset($offset);

                $query->get()->each(function ($item) use ($model, $foreign, $pivot, $bar) {
                    $modelObject = $model['class']::where('uuid', $item->model_uuid);
                    $foreignObject = $foreign['class']::where('uuid', $item->foreign_uuid);

                    if (in_array(SoftDeletes::class, class_uses($model['class']))) {
                        $modelObject->withTrashed();
                    }
                    $modelObject = $modelObject->first();

                    if (in_array(SoftDeletes::class, class_uses($foreign['class']))) {
                        $foreignObject->withTrashed();
                    }
                    $foreignObject = $foreignObject->first();

                    if ($modelObject && $foreignObject) {
                        DB::table(prefixTableName($pivot))
                            ->insert([
                                sprintf('%s_id', $model['field']) => $modelObject->id,
                                sprintf('%s_id', $foreign['field']) => $foreignObject->id,
                            ]);
                    }

                    $bar->advance(1);
                });
            }

            $bar->finish();
            $this->newLine();
            $result = DB::table(prefixTableName($pivot))->count();
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

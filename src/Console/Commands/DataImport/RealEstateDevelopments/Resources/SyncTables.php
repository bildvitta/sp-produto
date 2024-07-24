<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources;

use BildVitta\SpProduto\Models\Accessory;
use BildVitta\SpProduto\Models\AccessoryCategory;
use BildVitta\SpProduto\Models\BuyingOption;
use BildVitta\SpProduto\Models\Characteristic;
use BildVitta\SpProduto\Models\Environment;
use BildVitta\SpProduto\Models\HubCompany;
use BildVitta\SpProduto\Models\Insurance;
use BildVitta\SpProduto\Models\InsuranceCompany;
use BildVitta\SpProduto\Models\Personalization;
use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\ProposalModelPeriodicities;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

trait SyncTables
{
    private function hubCompanies(): void
    {
        $hub_companies = $this->getDatabase()->table('hub_companies');

        $this->syncData(
            $hub_companies,
            HubCompany::class,
            'Hub companies',
            [],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function accessoryCategories(): void
    {
        $accessoryCategories = $this->getDatabase()->table('categories as ca')
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

    private function accessories(): void
    {
        $accessories = $this->getDatabase()->table('accessories as ac')
            ->leftJoin('hub_companies as hc', 'ac.hub_company_id', '=', 'hc.id')
            ->leftJoin('categories as ca', 'ac.category_id', '=', 'ca.id')
            ->select('ac.*', 'hc.uuid as hub_company_uuid', 'ca.uuid as category_uuid');

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

    private function characteristics(): void
    {
        $characteristics = $this->getDatabase()->table('characteristics as ch')
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

    private function proposalModels(): void
    {
        $proposalModels = $this->getDatabase()->table('proposal_models as pm')
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

    private function proposalModelsPeriodicities(): void
    {
        $proposalModelsPeriodicities = $this->getDatabase()->table('proposal_model_periodicities as pp')
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

    private function buyingOptions(): void
    {
        $buyingOptions = $this->getDatabase()->table('buying_options as bo')
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

    private function insuranceCompanies(): void
    {
        $insuranceCompanies = $this->getDatabase()->table('insurance_companies as ic')
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

    private function insurances(): void
    {
        $insurances = $this->getDatabase()->table('insurances as i')
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

    private function realEstateDevelopments(): void
    {
        $realEstateDevelopments = $this->getDatabase()->table('real_estate_developments as red')
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

    private function proposalModelRealEstateDevelopment(): void
    {
        $proposalModelRealEstateDevelopment = $this->getDatabase()->table('proposal_model_real_estate_development as pr')
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

    private function buyingOptionRealEstateDevelopment(): void
    {
        $buyingOptionRealEstateDevelopment = $this->getDatabase()->table('buying_option_real_estate_development as br')
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

    private function insuranceCompanyRealEstateDevelopment(): void
    {
        $insuranceCompanyRealEstateDevelopment = $this->getDatabase()->table('insurance_company_real_estate_development as icr')
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

    private function insuranceRealEstateDevelopment(): void
    {
        $insuranceRealEstateDevelopment = $this->getDatabase()->table('insurance_real_estate_development as ir')
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

    private function realEstateDevelopmentCharacteristic(): void
    {
        $realEstateDevelopmentCharacteristic = $this->getDatabase()->table('real_estate_development_characteristics as rc')
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

    private function typologies(): void
    {
        $typologies = $this->getDatabase()->table('typologies as ty')
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

    private function realEstateDevelopmentAccessories(): void
    {
        $realEstateDevelopmentAccessories = $this->getDatabase()->table('real_estate_development_accessories as ra')
            ->leftJoin('real_estate_developments as red', 'ra.real_estate_development_id', '=', 'red.id')
            ->leftJoin('categories as ca', 'ra.category_id', '=', 'ca.id')
            ->leftJoin('accessories as acc', 'ra.accessory_id', '=', 'acc.id')
            ->select('ra.*', 'red.uuid as real_estate_development_uuid', 'ca.uuid as accessory_category_uuid', 'acc.uuid as accessory_uuid');

        $this->syncData(
            $realEstateDevelopmentAccessories,
            RealEstateDevelopment\Accessory::class,
            'Accessories for Real Estate Development',
            [
                'real_estate_development' => RealEstateDevelopment::class,
                'accessory_category' => AccessoryCategory::class,
                'accessory' => Accessory::class,
            ],
            ['created_at', 'updated_at', 'deleted_at', 'start_at', 'end_at']
        );
    }

    private function parameters(): void
    {
        $parameters = $this->getDatabase()->table('parameters as pa')
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

    private function mirrors(): void
    {
        $mirrors = $this->getDatabase()->table('mirrors as mi')
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

    private function mirrorGroups(): void
    {
        $mirrorGroups = $this->getDatabase()->table('mirror_groups as mg')
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

    private function blueprints(): void
    {
        $blueprints = $this->getDatabase()->table('blueprints as bl')
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

    private function blueprintImages(): void
    {
        $blueprint_images = $this->getDatabase()->table('blueprint_images as bi')
            ->leftJoin('blueprints as bp', 'bi.blueprint_id', '=', 'bp.id')
            ->select('bi.*', 'bp.uuid as blueprint_uuid');

        $this->syncData(
            $blueprint_images,
            RealEstateDevelopment\BlueprintImage::class,
            'Blueprint Images for Real Estate Development',
            ['blueprint' => RealEstateDevelopment\Blueprint::class],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function blueprintTypology(): void
    {
        $blueprint_typology = $this->getDatabase()->table('blueprint_typology as bt')
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

    private function proposalModelTypology(): void
    {
        $proposal_model_typology = $this->getDatabase()->table('proposal_model_typology as pt')
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

    private function realEstateDevelopmentAccessoryBlueprint(): void
    {
        $realEstateDevelopmentAccessoryBlueprint = $this->getDatabase()->table('real_estate_development_accessory_blueprint as ab')
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

    private function units(): void
    {
        $units = $this->getDatabase()->table('units as un')
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

        $accessories = $this->getDatabase()->table('real_estate_development_accessory_unit as redau')
            ->leftJoin('units as un', 'redau.unit_id', '=', 'un.id')
            ->leftJoin('real_estate_development_accessories as reda', 'redau.accessory_id', '=', 'reda.id')
            ->select('un.uuid as unit_uuid', 'reda.uuid as accessory_uuid');

        $this->syncRelated(
            $accessories,
            [
                'class' => RealEstateDevelopment\Unit::class,
                'field' => 'unit',
            ],
            [
                'class' => RealEstateDevelopment\Accessory::class,
                'field' => 'accessory',
            ],
            'real_estate_development_accessory_unit',
            'Acessories for Units'
        );
    }

    private function documents(): void
    {
        $documents = $this->getDatabase()->table('documents as dc')
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

    private function stages(): void
    {
        $stages = $this->getDatabase()->table('stages as st')
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

    private function stageImages(): void
    {
        $stage_images = $this->getDatabase()->table('stage_images as si')
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

    private function media(): void
    {
        $media = $this->getDatabase()->table('media as md')
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

    private function environments()
    {
        $environments = $this->getDatabase()->table('environments')
            ->select(['*']);

        $this->syncData(
            $environments,
            Environment::class,
            'Environments for Personalization',
            [],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function personalizations()
    {
        $personalizations = $this->getDatabase()->table('personalizations', 'p')
            ->leftJoin('real_estate_developments as red', 'p.real_estate_development_id', '=', 'red.id')
            ->select('p.*', 'red.uuid as real_estate_development_uuid');

        $this->syncData(
            $personalizations,
            Personalization::class,
            'Personalizations',
            ['real_estate_development' => RealEstateDevelopment::class],
            ['created_at', 'updated_at', 'deleted_at']
        );

        $environment_personalizations = $this->getDatabase()->table('environment_personalization', 'ep')
            ->leftJoin('environments as e', 'ep.environment_id', '=', 'e.id')
            ->leftJoin('personalizations as p', 'ep.personalization_id', '=', 'p.id')
            ->select('e.uuid as foreign_uuid', 'p.uuid as model_uuid');

        $this->syncRelated(
            $environment_personalizations,
            [
                'class' => Personalization::class,
                'field' => 'personalization',
            ],
            [
                'class' => Environment::class,
                'field' => 'environment',
            ],
            'environment_personalization',
            'Environment Personalizations'
        );
    }

    private function getDatabase(): ConnectionInterface
    {
        return DB::connection('produto');
    }
}

<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\Properties\Resources;

use BildVitta\SpProduto\Models\AutomobileBrand;
use BildVitta\SpProduto\Models\AutomobileDifferential;
use BildVitta\SpProduto\Models\AutomobileModel;
use BildVitta\SpProduto\Models\AutomobileVersion;
use BildVitta\SpProduto\Models\EstateDifferential;
use BildVitta\SpProduto\Models\HubCompany;
use BildVitta\SpProduto\Models\Property;
use BildVitta\SpProduto\Models\PropertyAttachment;
use BildVitta\SpProduto\Models\PropertyHolder;
use BildVitta\SpProduto\Models\PropertyImage;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

trait SyncTables
{
    private function automobile_brands()
    {
        $automobile_brands = $this->getDatabase()->table('automobile_brands');

        $this->syncData(
            $automobile_brands,
            AutomobileBrand::class,
            'Automobile brands',
            [],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function automobile_models()
    {
        $automobile_models = $this->getDatabase()->table('automobile_models as am')
            ->leftJoin('automobile_brands as ab', 'am.automobile_brand_id', '=', 'ab.id')
            ->select('am.*', 'ab.uuid as brand_uuid');

        $this->syncData(
            $automobile_models,
            AutomobileModel::class,
            'Automobile brands',
            [
                'brand' => AutomobileBrand::class,
            ],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function automobile_versions()
    {
        $automobile_versions = $this->getDatabase()->table('automobile_versions as av')
            ->leftJoin('automobile_models as am', 'av.automobile_model_id', '=', 'am.id')
            ->select('av.*', 'am.uuid as model_uuid');

        $this->syncData(
            $automobile_versions,
            AutomobileVersion::class,
            'Automobile versions',
            [
                'model' => AutomobileModel::class,
            ],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function automobile_differentials()
    {
        $automobile_differentials = $this->getDatabase()->table('automobile_differentials as ad');

        $this->syncData(
            $automobile_differentials,
            AutomobileDifferential::class,
            'Automobile differentials',
            [],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function estate_differentials()
    {
        $estate_differentials = $this->getDatabase()->table('estate_differentials as ed');

        $this->syncData(
            $estate_differentials,
            EstateDifferential::class,
            'Estate differentials',
            [],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function properties()
    {
        $properties = $this->getDatabase()->table('properties as p')
            ->leftJoin('automobile_brands as ab', 'p.brand_id', '=', 'ab.id')
            ->leftJoin('automobile_models as am', 'p.model_id', '=', 'am.id')
            ->leftJoin('automobile_versions as av', 'p.version_id', '=', 'av.id')
            ->leftJoin('hub_companies as hc', 'p.hub_company_id', '=', 'hc.id')
            ->select('p.*', 'ab.uuid as brand_uuid', 'am.uuid as model_uuid', 'av.uuid as version_uuid', 'hc.uuid as hub_company_uuid');

        $this->syncData(
            $properties,
            Property::class,
            'Properties',
            [
                'hub_company' => HubCompany::class,
                'brand' => AutomobileBrand::class,
                'model' => AutomobileModel::class,
                'version' => AutomobileVersion::class,
            ],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function property_attachments()
    {
        $property_attachments = $this->getDatabase()->table('property_attachments as pa')
            ->leftJoin('properties as p', 'pa.property_id', '=', 'p.id')
            ->select('pa.*', 'p.uuid as property_uuid');

        $this->syncData(
            $property_attachments,
            PropertyAttachment::class,
            'Property attachments',
            [
                'property' => Property::class,
            ],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function holder_property()
    {
        $propertyHolders = $this->getDatabase()->table('holder_property as ph')
            ->join('properties as p', 'ph.property_id', '=', 'p.id')
            ->select('ph.holder_uuid', 'p.uuid as property_uuid')
            ->get();

        PropertyHolder::query()->delete();

        foreach ($propertyHolders as $propertyHolder) {
            $propertyId = Property::query()
                ->where('uuid', $propertyHolder->property_uuid)
                ->value('id');
            if ($propertyId) {
                PropertyHolder::create([
                    'property_id' => $propertyId,
                    'holder_uuid' => $propertyHolder->holder_uuid,
                ]);
            }
        }
    }

    private function property_images()
    {
        $property_images = $this->getDatabase()->table('property_images as pi')
            ->leftJoin('properties as p', 'pi.property_id', '=', 'p.id')
            ->select('pi.*', 'p.uuid as property_uuid');

        $this->syncData(
            $property_images,
            PropertyImage::class,
            'Property images',
            [
                'property' => Property::class,
            ],
            ['created_at', 'updated_at', 'deleted_at']
        );
    }

    private function automobile_differential_property()
    {
        $automobileDifferentialProperties = $this->getDatabase()->table('automobile_differential_property as adp')
            ->join('automobile_differentials as ad', 'adp.automobile_differential_id', '=', 'ad.id')
            ->join('properties as p', 'adp.property_id', '=', 'p.id')
            ->select('adp.*', 'ad.uuid as automobile_differential_uuid', 'p.uuid as property_uuid')
            ->get();

        DB::table(prefixTableName('automobile_differential_property'))->delete();

        foreach ($automobileDifferentialProperties as $automobileDifferentialProperty) {
            $property = Property::query()
                ->where('uuid', $automobileDifferentialProperty->property_uuid)
                ->first();
            $automobileDiferential = AutomobileDifferential::query()
                ->where('uuid', $automobileDifferentialProperty->automobile_differential_uuid)
                ->first();
            if ($property && $automobileDiferential) {
                $property->automobile_differentials()->attach($automobileDiferential);
            }
        }
    }

    private function estate_differential_property()
    {
        $estateDifferentialProperties = $this->getDatabase()->table('estate_differential_property as edp')
            ->join('estate_differentials as ed', 'edp.estate_differential_id', '=', 'ed.id')
            ->join('properties as p', 'edp.property_id', '=', 'p.id')
            ->select('edp.*', 'ed.uuid as estate_differential_uuid', 'p.uuid as property_uuid')
            ->get();

        DB::table(prefixTableName('estate_differential_property'))->delete();

        foreach ($estateDifferentialProperties as $estateDifferentialProperty) {
            $property = Property::query()
                ->where('uuid', $estateDifferentialProperty->property_uuid)
                ->first();
            $estateDiferential = EstateDifferential::query()
                ->where('uuid', $estateDifferentialProperty->estate_differential_uuid)
                ->first();
            if ($property && $estateDiferential) {
                $property->estates_differentials()->attach($estateDiferential);
            }
        }
    }

    private function getDatabase(): ConnectionInterface
    {
        return DB::connection('produto');
    }
}

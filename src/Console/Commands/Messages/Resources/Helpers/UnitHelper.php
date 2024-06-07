<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Events\RealEstateDevelopments\RealEstateDevelopmentUpdated;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Accessory;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Blueprint;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Mirror;
use BildVitta\SpProduto\Models\RealEstateDevelopment\MirrorGroup;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Unit as BaseUnit;
use stdClass;
use Throwable;

trait UnitHelper
{
    private function unitUpdateOrCreate(stdClass $message): void
    {
        $realEstateDevelopment = RealEstateDevelopment::where('uuid', $message->real_estate_development_uuid)->first();

        $unit = BaseUnit::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'real_estate_development_id' => $realEstateDevelopment->id,
            'mirror_id' => $this->getUnitMirrorId($message->mirror_uuid),
            'mirror_group_id' => $this->getUnitMirrorGroupId($message->mirror_group_uuid),
            'blueprint_id' => $this->getUnitBlueprintId($message->blueprint_uuid),
            'typology_id' => $this->getUnitTypologyId($message->typology_uuid),
            'name' => $message->name,
            'code' => $message->code,
            'square_meters' => $message->square_meters,
            'fixed_price' => $message->fixed_price,
            'table_price' => $message->table_price,
            'special_needs' => $message->special_needs,
            'floor' => $message->floor,
            'unit_type' => $message->unit_type,
            'external_code' => $message->external_code,
            'external_subsidiary_code' => $message->external_subsidiary_code,
            'ideal_fraction' => $message->ideal_fraction,
            'factor' => $message->factor,
            'observations' => $message->observations,
            'ready_to_live_in' => $this->toCarbon($message->ready_to_live_in),
            'notary_registration' => $message->notary_registration,
            'property_tax_identification' => $message->property_tax_identification,
            'has_empty_fields' => $message->has_empty_fields,
            'has_furniture' => $message->has_furniture ?? null,
            'furniture_value' => $message->furniture_value ?? null,
            'garage_type' => $message->garage_type ?? null,
        ]);

        $accessories = Accessory::whereIn('uuid', $message->accessories)->get();
        $unit->accessories()->sync($accessories->pluck('id'));

        $this->unitPriceCalc($unit, $message);
        $this->unitSaleStep($unit, $realEstateDevelopment);

        if (config('sp-produto.events.real_estate_development_updated')) {
            event(new RealEstateDevelopmentUpdated($message->real_estate_development_uuid));
        }
    }

    private function unitDelete(stdClass $message): void
    {
        BaseUnit::where('uuid', $message->uuid)->delete();
        if (config('sp-produto.events.real_estate_development_updated')) {
            event(new RealEstateDevelopmentUpdated($message->real_estate_development_uuid));
        }
    }

    private function getUnitMirrorId(?string $mirrorUuid): ?int
    {
        if ($mirrorUuid) {
            return Mirror::where('uuid', $mirrorUuid)->first()?->id;
        }

        return null;
    }

    private function getUnitMirrorGroupId(?string $mirrorGroupUuid): ?int
    {
        if ($mirrorGroupUuid) {
            return MirrorGroup::where('uuid', $mirrorGroupUuid)->first()?->id;
        }

        return null;
    }

    private function getUnitBlueprintId(?string $blueprintUuid): ?int
    {
        if ($blueprintUuid) {
            return Blueprint::where('uuid', $blueprintUuid)->first()?->id;
        }

        return null;
    }

    private function getUnitTypologyId(?string $typologyUuid): ?int
    {
        if ($typologyUuid) {
            return Typology::where('uuid', $typologyUuid)->first()?->id;
        }

        return null;
    }

    private function unitPriceCalc(BaseUnit $baseUnit, stdClass $message): void
    {
        try {
            if (class_exists('\App\Models\Produto\Unit')) {
                $unit = \App\Models\Produto\Unit::where('uuid', $baseUnit->uuid)->first();
                if ($unit) {
                    $baseUnit->calculated_price = $unit->priceCalculated();
                    $baseUnit->save();
                }
            }
        } catch (Throwable $exception) {
            $this->logError($exception, $message);
        }
    }

    private function unitSaleStep(BaseUnit $unit, RealEstateDevelopment $realEstateDevelopment): void
    {
        if (empty($unit->sale_step_id) && class_exists('\App\Models\Settings\SaleStep')) {
            $defaultSaleStepID = \App\Models\Settings\SaleStep::whereHubCompanyId($realEstateDevelopment->hub_company_id)
                ->whereSlug('free')
                ->firstOrFail(['id'])
                ->id;
            $unit->sale_step_id = $defaultSaleStepID;
            $unit->save();
        }
    }
}

<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Blueprint;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Mirror;
use BildVitta\SpProduto\Models\RealEstateDevelopment\MirrorGroup;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Unit;
use stdClass;
use Throwable;

trait UnitHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function units(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $unityIds = [];
        foreach($message->units as $messageUnity) {
            $unit = Unit::updateOrCreate([
                'uuid' => $messageUnity->uuid,
            ], [
                'uuid' => $messageUnity->uuid,
                'real_estate_development_id' => $realEstateDevelopment->id,
                'mirror_id' => $this->getUnitMirrorId($messageUnity->mirror_uuid),
                'mirror_group_id' => $this->getUnitMirrorGroupId($messageUnity->mirror_group_uuid),
                'blueprint_id' => $this->getUnitBlueprintId($messageUnity->blueprint_uuid),
                'typology_id' => $this->getUnitTypologyId($messageUnity->typology_uuid),
                'name' => $messageUnity->name,
                'code' => $messageUnity->code,
                'square_meters' => $messageUnity->square_meters,
                'fixed_price' => $messageUnity->fixed_price,
                'special_needs' => $messageUnity->special_needs,
                'floor' => $messageUnity->floor,
                'unit_type' => $messageUnity->unit_type,
                'external_code' => $messageUnity->external_code,
                'external_subsidiary_code' => $messageUnity->external_subsidiary_code,
                'ideal_fraction' => $messageUnity->ideal_fraction,
                'factor' => $messageUnity->factor,
                'observations' => $messageUnity->observations,
                'ready_to_live_in' => $messageUnity->ready_to_live_in,
                'notary_registration' => $messageUnity->notary_registration,
                'property_tax_identification' => $messageUnity->property_tax_identification,
                'has_empty_fields' => $messageUnity->has_empty_fields,
            ]);
            $unityIds[] = $unit->id;
            try {
                $unit->calculated_price = $unit->priceCalculated();
                $unit->save();
            } catch(Throwable $exception) {
            }
        }
        Unit::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $unityIds)
            ->delete();
    }

    /**
     * @param string|null $mirrorUuid
     * @return int|null
     */
    private function getUnitMirrorId(?string $mirrorUuid): ?int
    {
        if ($mirrorUuid) {
            return Mirror::where('uuid', $mirrorUuid)->first()?->id;
        }
        return null;
    }

    /**
     * @param string|null $mirrorGroupUuid
     * @return int|null
     */
    private function getUnitMirrorGroupId(?string $mirrorGroupUuid): ?int
    {
        if ($mirrorGroupUuid) {
            return MirrorGroup::where('uuid', $mirrorGroupUuid)->first()?->id;
        }
        return null;
    }

    /**
     * @param string|null $blueprintUuid
     * @return int|null
     */
    private function getUnitBlueprintId(?string $blueprintUuid): ?int
    {
        if ($blueprintUuid) {
            return Blueprint::where('uuid', $blueprintUuid)->first()?->id;
        }
        return null;
    }

    /**
     * @param string|null $typologyUuid
     * @return int|null
     */
    private function getUnitTypologyId(?string $typologyUuid): ?int
    {
        if ($typologyUuid) {
            return Typology::where('uuid', $typologyUuid)->first()?->id;
        }
        return null;
    }
  
}

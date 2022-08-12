<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Characteristic as BaseCharacteristic;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Characteristic;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait CharacteristicHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function characteristics(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $characteristicIds = [];
        foreach ($message->characteristics as $messageCharacteristics) {
            $baseCharacteristic = BaseCharacteristic::updateOrCreate([
                'uuid' => $messageCharacteristics->characteristic->uuid,
            ], [
                'uuid' => $messageCharacteristics->characteristic->uuid,
                'name' => $messageCharacteristics->characteristic->name,
                'description' => $messageCharacteristics->characteristic->description,
                'icon' => $messageCharacteristics->characteristic->icon,
                'hub_company_id' => $realEstateDevelopment->hub_company_id,
            ]);
            $characteristic = Characteristic::updateOrCreate([
                'uuid' => $messageCharacteristics->uuid,
            ], [
                'uuid' => $messageCharacteristics->uuid,
                'real_estate_development_id' => $realEstateDevelopment->id,
                'description' => $messageCharacteristics->description,
                'order' => $messageCharacteristics->order,
                'differential' => $messageCharacteristics->differential,
                'characteristic_id' => $baseCharacteristic->id,
            ]);
            $characteristicIds[] = $characteristic->id;
        }
        Characteristic::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $characteristicIds)
            ->delete();
    }
}

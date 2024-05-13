<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Characteristic as BaseCharacteristic;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Characteristic;
use stdClass;

trait RealEstateDevelopmentCharacteristicHelper
{
    private function realEstateDevelopmentCharacteristicUpdateOrCreate(stdClass $message): void
    {
        $realEstateDevelopmentId = RealEstateDevelopment::where('uuid', $message->real_estate_development_uuid)->value('id');
        $baseCharacteristic = BaseCharacteristic::updateOrCreate([
            'uuid' => $message->characteristic->uuid,
        ], [
            'uuid' => $message->characteristic->uuid,
            'name' => $message->characteristic->name,
            'description' => $message->characteristic->description,
            'icon' => $message->characteristic->icon,
            'hub_company_id' => $this->hubCompanyId($message->characteristic),
        ]);
        Characteristic::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'real_estate_development_id' => $realEstateDevelopmentId,
            'description' => $message->description,
            'order' => $message->order,
            'differential' => $message->differential,
            'characteristic_id' => $baseCharacteristic->id,
        ]);
    }

    private function realEstateDevelopmentCharacteristicDelete(stdClass $message): void
    {
        Characteristic::where('uuid', $message->uuid)->delete();
    }
}

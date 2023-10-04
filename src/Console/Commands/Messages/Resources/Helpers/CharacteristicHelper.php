<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Events\RealEstateDevelopments\RealEstateDevelopmentUpdated;
use BildVitta\SpProduto\Models\Characteristic as BaseCharacteristic;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Characteristic;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait CharacteristicHelper
{
    /**
     * @param stdClass $message
     * @return void
     */
    private function characteristicUpdateOrCreate(stdClass $message): void
    {
        $realEstateDevelopment = RealEstateDevelopment::where('uuid', $message->real_estate_development_uuid)->first();

        $baseCharacteristic = BaseCharacteristic::updateOrCreate([
            'uuid' => $message->characteristic->uuid,
        ], [
            'uuid' => $message->characteristic->uuid,
            'name' => $message->characteristic->name,
            'description' => $message->characteristic->description,
            'icon' => $message->characteristic->icon,
            'hub_company_id' => $realEstateDevelopment->hub_company_id,
        ]);
        $characteristic = Characteristic::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'real_estate_development_id' => $realEstateDevelopment->id,
            'description' => $message->description,
            'order' => $message->order,
            'differential' => $message->differential,
            'characteristic_id' => $baseCharacteristic->id,
        ]);

        if (config('sp-produto.events.real_estate_development_updated')) {
            event(new RealEstateDevelopmentUpdated($message->real_estate_development_uuid));
        }
    }

    /**
     * @param stdClass $message
     * @return void
     */
    private function characteristicDelete(stdClass $message): void
    {
        Characteristic::where('uuid', $message->uuid)->delete();

        if (config('sp-produto.events.real_estate_development_updated')) {
            event(new RealEstateDevelopmentUpdated($message->real_estate_development_uuid));
        }
    }
}

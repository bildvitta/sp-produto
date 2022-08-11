<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Accessory as BaseAccessory;
use BildVitta\SpProduto\Models\AccessoryCategory;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Accessory;
use Carbon\Carbon;
use stdClass;

trait AccessoriesHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function accessories(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $accessories = collect($message->accessories);
        $accessories->groupBy('accessory.category_id')->each(function (object $realStateAccessories) use ($realEstateDevelopment) {
            if (is_null($realStateAccessories[0]->accessory_categorization)) {
                return null;
            }
            $accessoryCategory = AccessoryCategory::updateOrCreate([
                'uuid' => $realStateAccessories[0]->accessory_categorization->uuid,
            ], [
                'uuid' => $realStateAccessories[0]->accessory_categorization->uuid,
                'hub_company_id' => $realEstateDevelopment->hub_company_id,
                'name' => $realStateAccessories[0]->accessory_categorization->name,
                'description' => $realStateAccessories[0]->accessory_categorization->description,
            ]);
            foreach ($realStateAccessories as $realStateAccessory) {
                if ($realStateAccessory->accessory) {
                    $baseAccessory = BaseAccessory::updateOrCreate([
                        'uuid' => $realStateAccessory->accessory->uuid,
                    ], [
                        'uuid' => $realStateAccessory->accessory->uuid,
                        'hub_company_id' => $realEstateDevelopment->hub_company_id,
                        'category_id' => $accessoryCategory->id,
                        'name' => $realStateAccessory->accessory->name,
                        'description' => $realStateAccessory->accessory->description,
                    ]);
                    Accessory::updateOrCreate([
                        'uuid' => $realStateAccessory->uuid,
                    ], [
                        'uuid' => $realStateAccessory->uuid,
                        'real_estate_development_id' => $realEstateDevelopment->id,
                        'accessory_id' => $baseAccessory->id,
                        'accessory_category_id' => $accessoryCategory->id,
                        'order' => $realStateAccessory->order,
                        'all_typologies' => $realStateAccessory->all_typologies,
                        'start_at' => $realStateAccessory->start_at ? Carbon::create($realStateAccessory->start_at) : null,
                        'end_at' => $realStateAccessory->end_at ? Carbon::create($realStateAccessory->end_at) : null,
                        'stock_quantity' => $realStateAccessory->stock_quantity,
                        'personalization' => $realStateAccessory->personalization,
                        'category_id' => $realStateAccessory->category_id,
                    ]);
                }
            }
        });
    }
}

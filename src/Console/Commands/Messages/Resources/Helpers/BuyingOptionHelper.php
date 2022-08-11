<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\BuyingOption;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait BuyingOptionHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function buyingOptions(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $buyingOptionIds = [];
        foreach ($message->buying_options as $buying_option) {
            $buyingOption = BuyingOption::updateOrCreate([
                'uuid' => $buying_option->uuid,
            ], [
                'uuid' => $buying_option->uuid,
                'income_commitment' => $buying_option->income_commitment,
                'name' => $buying_option->name,
                'when_flow_sent' => $buying_option->when_flow_sent,
                'when_flow_validated' => $buying_option->when_flow_validated,
                'when_make_sale' => $buying_option->when_make_sale,
                'when_reserve_unit' => $buying_option->when_reserve_unit,
                'hub_company_id' => $realEstateDevelopment->hub_company_id,
            ]);
            $buyingOptionIds[] = $buyingOption->id;
        }
        $realEstateDevelopment->buying_options()->sync($buyingOptionIds);
    }
}

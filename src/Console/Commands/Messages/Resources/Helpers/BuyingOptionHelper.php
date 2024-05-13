<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\BuyingOption;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait BuyingOptionHelper
{
    private function buyingOptions(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $buyingOptionIds = [];
        foreach ($message->buying_options as $buying_option) {
            if ($buyingOptionId = BuyingOption::where('uuid', $buying_option->uuid)->value('id')) {
                $buyingOptionIds[] = $buyingOptionId;
            }
        }
        $realEstateDevelopment->buying_options()->sync($buyingOptionIds);
    }

    private function buyingOptionUpdateOrCreate(stdClass $message): void
    {
        BuyingOption::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'income_commitment' => $message->income_commitment,
            'name' => $message->name,
            'when_flow_sent' => $message->when_flow_sent,
            'when_flow_validated' => $message->when_flow_validated,
            'when_make_sale' => $message->when_make_sale,
            'when_reserve_unit' => $message->when_reserve_unit,
            'hub_company_id' => $this->hubCompanyId($message),
        ]);
    }

    private function buyingOptionDelete(stdClass $message): void
    {
        BuyingOption::where('uuid', $message->uuid)->delete();
    }
}

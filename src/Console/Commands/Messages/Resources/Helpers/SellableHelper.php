<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait SellableHelper
{
    private function sellableBy(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        // get local id from message uuids.
        $ids = app(config('sp-produto.model_company'))::whereIn('uuid', collect($message->sellable_by)->pluck('uuid')->toArray())->pluck('id')->toArray();

        // sync local ids with pivot table.
        $realEstateDevelopment->sellable_by()->sync($ids);
    }
}

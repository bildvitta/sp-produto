<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Unit as BaseUnit;
use stdClass;

trait UnitPriceHelper
{
    private function unitPriceUpdateOrCreate(stdClass $unitPrice): void
    {
        $unit = BaseUnit::whereUuid($unitPrice->unit_uuid)->first();

        if ($unit) {
            $unit->prices()->updateOrCreate([
                'uuid' => $unitPrice->uuid,
            ], [
                'period' => $unitPrice->period,
                'fixed_price' => $unitPrice->fixed_price,
                'table_price' => $unitPrice->table_price,
                'created_at' => $unitPrice->created_at,
                'updated_at' => $unitPrice->updated_at,
            ]);
        }
    }

    private function unitPriceDelete(stdClass $unitPrice)
    {
        BaseUnit::whereUuid($unitPrice->unit_uuid)
            ->firstOrFail()
            ->prices()
            ->whereUuid($unitPrice->uuid)
            ->delete();
    }
}

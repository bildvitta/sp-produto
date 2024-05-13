<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\AccessoryCategory;
use stdClass;

trait CategoriesHelper
{
    private function categoryUpdateOrCreate(stdClass $message): void
    {
        AccessoryCategory::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'name' => $message->name,
            'description' => $message->description,
            'hub_company_id' => $this->hubCompanyId($message),
        ]);
    }

    private function categoryDelete(stdClass $message): void
    {
        AccessoryCategory::where('uuid', $message->uuid)->delete();
    }
}

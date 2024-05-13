<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Attribute;
use stdClass;

trait AttributeHelper
{
    private function attributeUpdateOrCreate(stdClass $message): void
    {
        Attribute::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'name' => $message->name,
            'description' => $message->description,
            'type_increase' => $message->type_increase,
            'value_increase' => $message->value_increase,
            'hub_company_id' => $this->hubCompanyId($message),
        ]);
    }

    private function attributeDelete(stdClass $message): void
    {
        Attribute::where('uuid', $message->uuid)->delete();
    }
}

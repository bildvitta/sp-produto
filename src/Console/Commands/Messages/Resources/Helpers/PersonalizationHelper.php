<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Environment;
use BildVitta\SpProduto\Models\Personalization;
use BildVitta\SpProduto\Models\RealEstateDevelopment;

trait PersonalizationHelper
{
    protected function personalizationUpdateOrCreate($message)
    {
        $realEstateDevelopment = RealEstateDevelopment::where('uuid', $message->real_estate_development)->first();
        $environments = Environment::whereIn('uuid', $message->environments)->get();

        $document = Personalization::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'is_active' => $message->is_active,
            'name' => $message->name,
            'value' => $message->value,
            'real_estate_development_id' => $realEstateDevelopment->id,
            'description' => $message->description,
            'created_at' => $message->created_at,
            'updated_at' => $message->updated_at,
        ]);

        $document->environments()->sync($environments);
    }

    protected function personalizationDelete($message)
    {
        Personalization::where('uuid', $message->uuid)->delete();
    }
}

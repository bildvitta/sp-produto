<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Environment;

trait EnvironmentHelper
{
    protected function environmentUpdateOrCreate($message)
    {
        Environment::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'name' => $message->name,
            'created_at' => $message->created_at,
            'updated_at' => $message->updated_at,
        ]);
    }

    protected function environmentDelete($message)
    {
        Environment::where('uuid', $message->uuid)->delete();
    }
}

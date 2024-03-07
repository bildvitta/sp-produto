<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use Carbon\Carbon;

trait Tools
{
    /**
     * @param  mixed  $field
     */
    private function toCarbon($field): ?Carbon
    {
        if ($field && ! in_array(substr($field, 0, 4), ['0000', '-000'])) {
            return Carbon::create($field);
        }

        return null;
    }

    private function configHas(string $relation): bool
    {
        $syncRelations = config('sp-produto.sync_relations');
        if (is_array($syncRelations)) {
            return in_array($relation, $syncRelations);
        }

        return false;
    }
}

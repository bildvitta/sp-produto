<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use Carbon\Carbon;

trait Tools
{
    /**
     * @param mixed $field
     * @return Carbon|null
     */
    private function toCarbon($field): ?Carbon
    {
        if ($field) {
            return Carbon::create($field);
        }

        return null;
    }

    /**
     * @param string $relation
     * @return bool
     */
    private function configHas(string $relation): bool
    {
        $syncRelations = config('sp-produto.sync_relations');
        if (is_array($syncRelations)) {
            return in_array($relation, $syncRelations);
        }
        return false;
    }
}

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
}

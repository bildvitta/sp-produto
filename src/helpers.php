<?php

if (! function_exists('prefixTableName')) {
    /**
     * Set table name with prefix.
     */
    function prefixTableName(string $name): string
    {
        return sprintf('%s%s', config('sp-produto.table_prefix'), $name);
    }
}

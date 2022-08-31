<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources;

trait UpdateWorker
{
    /**
     * @param array $props
     * @return void
     */
    private function updateWorker(array $props): void
    {
        foreach ($props as $key => $value) {
            $this->worker->{$key} = $value;
        }
        $this->worker->created_at = now();
        $this->worker->save();
    }
}

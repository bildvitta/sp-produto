<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\Properties\Resources;

use BildVitta\SpProduto\Console\Commands\DataImport\Properties\Jobs\PropertyImportJob;
use BildVitta\SpProduto\Models\Worker;

trait DispatchNextJob
{
    private function dispatchNextJob(): void
    {
        $this->worker = Worker::find($this->workerId);
        if (! $this->worker) {
            return;
        }

        $payload = $this->worker->payload;
        $nextOffset = $payload->offset + $payload->limit;

        if ($nextOffset < $payload->total) {
            $this->handleNextOffset($payload, $nextOffset);
        } else {
            $this->handleNextTable($payload);
        }
    }

    private function handleNextOffset($payload, $nextOffset): void
    {
        $payload->offset = $nextOffset;
        $this->updateWorker(['payload' => $payload]);
        PropertyImportJob::dispatch($this->worker->id);
    }

    private function handleNextTable($payload): void
    {
        $nextTableIndex = $payload->table_index + 1;
        if (isset($payload->tables[$nextTableIndex])) {
            $this->prepareForNextTable($payload, $nextTableIndex);
        } else {
            $this->finishJobs($payload);
        }
    }

    private function prepareForNextTable($payload, $nextTableIndex): void
    {
        $payload->table_index = $nextTableIndex;
        $payload->offset = 0;
        $payload->total = null;
        $this->updateWorker(['payload' => $payload]);
        PropertyImportJob::dispatch($this->worker->id);
    }

    private function finishJobs($payload): void
    {
        unset($payload->table_index);
        unset($payload->offset);
        unset($payload->total);
        $payload->finished_jobs = true;
        $this->updateWorker(['payload' => $payload, 'status' => 'finished']);
    }
}

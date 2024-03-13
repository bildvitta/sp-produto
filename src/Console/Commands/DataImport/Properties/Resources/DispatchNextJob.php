<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\Properties\Resources;

use BildVitta\SpProduto\Console\Commands\DataImport\Properties\Jobs\PropertyImportJob;
use BildVitta\SpProduto\Models\Worker;

trait DispatchNextJob
{
    private function dispatchNextJob(): void
    {
        if (! $this->worker = Worker::find($this->workerId)) {
            return;
        }
        $payload = $this->worker->payload;
        $nextOffset = $payload->offset + $payload->limit;

        if ($nextOffset < $payload->total) {
            $payload->offset = $nextOffset;
            $this->updateWorker(['payload' => $payload]);
            PropertyImportJob::dispatch($this->worker->id);
        } else {
            $nextTableIndex = $payload->table_index + 1;
            if (isset($payload->tables[$nextTableIndex])) {
                $payload->table_index = $nextTableIndex;
                $payload->offset = 0;
                $payload->total = null;
                $this->updateWorker(['payload' => $payload]);
                PropertyImportJob::dispatch($this->worker->id);
            } else {
                unset($payload->table_index);
                unset($payload->offset);
                unset($payload->total);
                $payload->finished_jobs = true;
                $this->updateWorker(['payload' => $payload, 'status' => 'finished']);
            }
        }
    }
}

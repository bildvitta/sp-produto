<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Worker;
use Throwable;

trait LogHelper
{
    /**
     * @param  mixed  $message
     */
    private function logError(Throwable $exception, $message): void
    {
        try {
            $worker = new Worker();
            $worker->type = 'rabbitmq.worker.error';
            $worker->payload = [
                'message' => $message,
            ];
            $worker->status = 'error';
            $worker->error = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ];
            $worker->schedule = now();
            $worker->save();
        } catch (Throwable $throwable) {
            throw $exception;
        }
    }
}

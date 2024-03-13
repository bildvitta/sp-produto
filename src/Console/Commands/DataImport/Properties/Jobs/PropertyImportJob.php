<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\Properties\Jobs;

use BildVitta\SpProduto\Console\Commands\DataImport\Properties\Resources\DispatchNextJob;
use BildVitta\SpProduto\Console\Commands\DataImport\Properties\Resources\SyncTables;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\Connection;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\SyncData;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\SyncRelated;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\UpdateWorker;
use BildVitta\SpProduto\Models\Worker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use Throwable;

class PropertyImportJob implements ShouldQueue
{
    use Connection;
    use Dispatchable;
    use DispatchNextJob;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use SyncData;
    use SyncRelated;
    use SyncTables;
    use UpdateWorker;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3300;

    /**
     * @var int
     */
    public $retryAfter = 60;

    private int $workerId;

    private string $currentTable;

    /**
     * @var Worker
     */
    private $worker;

    public function __construct(int $workerId)
    {
        $this->onQueue('default');
        $this->workerId = $workerId;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function handle()
    {
        if (! $this->worker = Worker::find($this->workerId)) {
            return;
        }
        $this->init();

        switch ($this->currentTable) {
            case 'automobile_brands':
                $this->automobile_brands();
                break;
            case 'automobile_models':
                $this->automobile_models();
                break;
            case 'automobile_versions':
                $this->automobile_versions();
                break;
            case 'automobile_differentials':
                $this->automobile_differentials();
                break;
            case 'estate_differentials':
                $this->estate_differentials();
                break;
            case 'properties':
                $this->properties();
                break;
            case 'property_attachments':
                $this->property_attachments();
                break;
            case 'property_holders':
                $this->property_holders();
                break;
            case 'property_images':
                $this->property_images();
                break;
            case 'automobile_differential_property':
                $this->automobile_differential_property();
                break;
            case 'estate_differential_property':
                $this->estate_differential_property();
                break;
            default:
                throw new InvalidArgumentException('Invalid current table: '.$this->currentTable);
        }

        $this->dispatchNextJob();
    }

    private function init(): void
    {
        $this->configConnection();
        $this->updateWorker(['status' => 'in_progress']);
        $this->currentTable = $this->worker->payload->tables[$this->worker->payload->table_index];
    }

    public function failed(Throwable $exception): void
    {
        if (! $worker = Worker::find($this->workerId)) {
            return;
        }
        $worker->error = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ];
        $worker->status = 'error';
        $worker->save();
    }
}

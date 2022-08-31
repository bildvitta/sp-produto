<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Worker;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\Connection;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\DispatchNextJob;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\SyncData;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\SyncRelated;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\SyncTables;
use BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources\UpdateWorker;
use InvalidArgumentException;
use Throwable;

class RealEstateDevelopmentImportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Connection;
    use SyncData;
    use SyncRelated;
    use SyncTables;
    use DispatchNextJob;
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

    /**
     * @var int
     */
    private int $workerId;

    /**
     * @var string
     */
    private string $currentTable;

    /**
     * @var Worker
     */
    private $worker;

    /**
     * @param int $workerId
     */
    public function __construct(int $workerId)
    {
        $this->onQueue('default');
        $this->workerId = $workerId;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function handle()
    {
        if (! $this->worker = Worker::find($this->workerId)) {
            return;
        }
        $this->init();

        switch ($this->currentTable) {
            case 'hub_companies':
                $this->hubCompanies();
                break;
            case 'accessory_categories':
                $this->accessoryCategories();
                break;
            case 'accessories':
                $this->accessories();
                break;
            case 'characteristics':
                $this->characteristics();
                break;
            case 'proposal_models':
                $this->proposalModels();
                break;
            case 'proposal_model_periodicities':
                $this->proposalModelsPeriodicities();
                break;
            case 'buying_options':
                $this->buyingOptions();
                break;
            case 'insurance_companies':
                $this->insuranceCompanies();
                break;
            case 'insurances':
                $this->insurances();
                break;
            case 'real_estate_developments':
                $this->realEstateDevelopments();
                break;
            case 'proposal_model_real_estate_development':
                $this->proposalModelRealEstateDevelopment();
                break;
            case 'buying_option_real_estate_development':
                $this->buyingOptionRealEstateDevelopment();
                break;
            case 'insurance_company_real_estate_development':
                $this->insuranceCompanyRealEstateDevelopment();
                break;
            case 'insurance_real_estate_development':
                $this->insuranceRealEstateDevelopment();
                break;
            case 'characteristic_real_estate_development':
                $this->realEstateDevelopmentCharacteristic();
                break;
            case 'typologies':
                $this->typologies();
                break;
            case 'real_estate_development_accessories':
                $this->realEstateDevelopmentAccessories();
                break;
            case 'parameters':
                $this->parameters();
                break;
            case 'mirrors':
                $this->mirrors();
                break;
            case 'mirror_groups':
                $this->mirrorGroups();
                break;
            case 'blueprints':
                $this->blueprints();
                break;
            case 'blueprint_images':
                $this->blueprintImages();
                break;
            case 'blueprint_typology':
                $this->blueprintTypology();
                break;
            case 'proposal_model_typology':
                $this->proposalModelTypology();
                break;
            case 'real_estate_development_accessory_blueprint':
                $this->realEstateDevelopmentAccessoryBlueprint();
                break;
            case 'units':
                $this->units();
                break;
            case 'documents':
                $this->documents();
                break;
            case 'stages':
                $this->stages();
                break;
            case 'stage_images':
                $this->stageImages();
                break;
            case 'media':
                $this->media();
                break;
            default:
                throw new InvalidArgumentException('Invalid current table');
        }

        $this->dispatchNextJob();
    }

    /**
     * @return void
     */
    private function init(): void
    {
        $this->configConnection();
        $this->updateWorker(['status' => 'in_progress']);
        $this->currentTable = $this->worker->payload->tables[$this->worker->payload->table_index];
    }

    /**
     * @param Throwable $exception
     * @return void
     */
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

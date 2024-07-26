<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\SpProduto\Factories\ProposalModelPeriodicitiesFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProposalModelPeriodicities.
 */
class ProposalModelPeriodicities extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'proposal_model_periodicities';
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ProposalModelPeriodicitiesFactory::new();
    }

    public const PERIODICITY_LIST = [
        'financing' => 'Financiamento',
        'fgts' => 'FGTS',
        'subsidy' => 'Subsídio',
        'down_payment' => 'Entrada',
        'intermediate' => 'Intermediária',
        'post_construction' => 'Pós-obra',
        'monthly' => 'Mensal',
        'bimonthly' => 'Bimestral',
        'quarterly' => 'Trimestral',
        'semiannual' => 'Semestral',
        'yearly' => 'Anual',
        'conclusion_balance' => 'Saldo Conclusão',
        'final' => 'Final',
    ];

    public const DUE_DATE_TYPE_LIST = [
        // 'blueprint_definition_deadline' => 'Data limite para definição de planta',
        'construction_over_in' => 'Data de entrega da obra',
        // 'construction_prevision_in' => 'Data de previsão de entrega da obra',
        // 'construction_start_in' => 'Data de início da obra',
        // 'financial_transfer_deadline' => 'Data limite para repasse',
        // 'launch_in' => 'Data de lançamento',
        'pre_launch_in' => 'Data de breve lançamento',
        'ready_to_live_in' => 'Data de entrega real',
        'hand_over_keys_in' => 'Data de entrega das chaves',
    ];

    /**
     * @const array[]
     */
    public const ADD_ON_TYPE_LIST = [
        'fixed_value' => 'Valor fixo',
        'percentage' => 'Porcentagem',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'proposal_model_id',
        'update_installments_quantity',
        'installments',
        'periodicity',
        'pin_value',
        'add_on_type',
        'add_on_value',
        'editable',
        'due_date_type',
        'due_dates',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'update_installments_quantity' => 'boolean',
        'pin_value' => 'boolean',
        'editable' => 'boolean',
    ];

    public function proposalModel(): BelongsTo
    {
        return $this->belongsTo(ProposalModel::class);
    }

    /**
     * Get hub company
     */
    public function hub_company(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_company'));
    }
}

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
        'periodicity_quantity',
        'pin_value',
        'add_on_type',
        'add_on_value',
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

<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProposalModelPeriodicities.
 *
 * @package BildVitta\SpProduto\Models
 */
class ProposalModelPeriodicities extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('proposal_model_periodicities');
    }

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

    /**
     * @return BelongsTo
     */
    public function proposalModel(): BelongsTo
    {
        return $this->belongsTo(ProposalModel::class);
    }

    /**
     * Get hub company
     *
     * @return BelongsTo
     */
    public function hub_company(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_company'));
    }
}

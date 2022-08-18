<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BuyingOption.
 *
 * @package BildVitta\SpProduto\Models
 */
class BuyingOption extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('buying_options');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'income_commitment',
        'name',
        'when_flow_sent',
        'when_flow_validated',
        'when_make_sale',
        'when_reserve_unit',
        'hub_company_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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

<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AccessoryCategory.
 *
 * @package BildVitta\SpProduto\Models
 */
class AccessoryCategory extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('accessory_categories');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'description',
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

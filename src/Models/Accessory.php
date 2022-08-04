<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Accessory.
 *
 * @package BildVitta\SpProduto\Models
 */
class Accessory extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('accessory');
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
        'category_id',
        'hub_company_id'
    ];

    /**
     * Accessory category
     *
     * @return BelongsTo
     */
    public function accessory_categorization(): BelongsTo
    {
        return $this->belongsTo(AccessoryCategory::class, 'category_id', 'id');
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

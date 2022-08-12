<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProposalModel.
 *
 * @package BildVitta\SpProduto\Models
 */
class Characteristic extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('real_estate_development_characteristics');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'order',
        'differential',
        'description',
        'real_estate_development_id',
        'characteristic_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['differential' => 'boolean'];

    /**
     * @return BelongsTo
     */
    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }

    /**
     * @return BelongsTo
     */
    public function characteristic(): BelongsTo
    {
        return $this->belongsTo(\BildVitta\SpProduto\Models\Characteristic::class, 'characteristic_id');
    }
}

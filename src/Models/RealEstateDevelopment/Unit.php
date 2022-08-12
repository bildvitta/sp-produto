<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Unit.
 *
 * @package BildVitta\SpProduto\Models
 */
class Unit extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('units');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'code',
        'unit_type',
        'floor',
        'square_meters',
        'ideal_fraction',
        'fixed_price',
        'factor',
        'special_needs',
        'observations',
        'ready_to_live_in',
        'notary_registration',
        'property_tax_identification',
        'real_estate_development_id',
        'typology_id',
        'mirror_id',
        'mirror_group_id',
        'external_code',
        'external_subsidiary_code',
        'blueprint_id'
    ];

    /**
     * @return BelongsTo
     */
    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }
}

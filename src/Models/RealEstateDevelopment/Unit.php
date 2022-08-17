<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use App\Models\Settings\SaleStep;
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
        'blueprint_id',
    ];

    /**
     * @return BelongsTo
     */
    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }

    /**
     * Get the typologies for the unit.
     */
    public function typology()
    {
        return $this->belongsTo(Typology::class);
    }

    /**
     * Get the accessories for the unit.
     */
    public function real_estate_developments_accessories()
    {
        return $this->typology ? $this->typology->accessories() : collect([]);
    }

    /**
     * Get the blueprints for the unit.
     *
     * @return BelongsTo
     */
    public function real_estate_developments_blueprints(): BelongsTo
    {
        return $this->belongsTo(Blueprint::class, 'blueprint_id');
    }

    /**
     * Get the mirrors group for the unit.
     *
     * @return BelongsTo
     */
    public function mirror_group(): BelongsTo
    {
        return $this->belongsTo(Mirror::class, 'mirror_id');
    }

    /**
     * Get the mirrors subgroups for the unit.
     *
     * @return BelongsTo
     */
    public function mirror_subgroup(): BelongsTo
    {
        return $this->belongsTo(MirrorGroup::class, 'mirror_group_id');
    }

    public function getTypologyUuidAttribute(): Typology|string|null
    {
        return $this->typology;
    }

    public function blueprint()
    {
        return $this->belongsTo(Blueprint::class);
    }

    public function saleStep(): BelongsTo
    {
        return $this->belongsTo(SaleStep::class);
    }
}

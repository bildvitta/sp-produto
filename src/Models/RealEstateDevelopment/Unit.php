<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\UnitFactory;
use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Unit.
 */
class Unit extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'units';
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return UnitFactory::new();
    }

    /**
     * Type of unity.
     *
     * @const string
     */
    public const UNIT_TYPE_LIST = [
        'residential' => 'Residencial',
        'commercial' => 'Comercial',
        'garage' => 'Garagem',
        'storage' => 'Armazém',
    ];

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
        'table_price',
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
        'garage_type',
        'has_furniture',
        'furniture_value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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
     */
    public function real_estate_developments_blueprints(): BelongsTo
    {
        return $this->belongsTo(Blueprint::class, 'blueprint_id');
    }

    /**
     * Get the mirrors group for the unit.
     */
    public function mirror_group(): BelongsTo
    {
        return $this->belongsTo(Mirror::class, 'mirror_id');
    }

    /**
     * Get the mirrors subgroups for the unit.
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
}

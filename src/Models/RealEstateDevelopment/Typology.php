<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\TypologyFactory;
use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Typology
 *
 * @package BildVitta\SpProduto\Models
 */
class Typology extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'real_estate_development_id',
        'extract_text',
        'itbi_value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'itbi_value' => 'real',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix') . 'typologies';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return TypologyFactory::new();
    }

    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }

    /**
     * Get the real estate development proposal models.
     *
     * @return BelongsToMany
     */
    public function real_estate_developments_proposal_model(): BelongsToMany
    {
        return $this->belongsToMany(ProposalModel::class, config('sp-produto.table_prefix') . 'proposal_model_typology', 'typology_id', 'proposal_model_id');
    }

    /**
     * Define a many-to-many relationship.
     *
     * @return BelongsToMany
     */
    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(RealEstateDevelopment\Accessory::class, config('sp-produto.table_prefix') . 'real_estate_development_accessory_typology');
    }

    /**
     * Get blueprints for typology.
     *
     * @return BelongsToMany
     */
    public function blueprints(): BelongsToMany
    {
        return $this->belongsToMany(Blueprint::class, config('sp-produto.table_prefix') . 'blueprint_typology')
            ->with('real_estate_developments_blueprint_images');
    }

    /**
     * Define a one-to-many relationship.
     *
     * @return HasMany
     */
    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}

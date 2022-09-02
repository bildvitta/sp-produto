<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\BlueprintFactory;
use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Blueprints.
 *
 * @package BildVitta\SpProduto\Models
 */
class Blueprint extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix') . 'blueprints';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return BlueprintFactory::new();
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
        'real_estate_development_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }

    /**
     * @return BelongsToMany
     */
    public function typologies(): BelongsToMany
    {
        return $this->belongsToMany(Typology::class, prefixTableName('blueprint_typology'));
    }

    /**
     * @return BelongsToMany
     */
    public function real_estate_development_accessories(): BelongsToMany
    {
        return $this->belongsToMany(
            RealEstateDevelopment\Accessory::class,
            prefixTableName('blueprint_real_estate_development_accessory'),
            'blueprint_id',
            'real_estate_development_accessory_id'
        );
    }

    /**
     * Get real estate development blueprint images.
     *
     * @return HasMany
     */
    public function real_estate_developments_blueprint_images(): HasMany
    {
        return $this->hasMany(BlueprintImage::class);
    }

    public function images()
    {
        return $this->real_estate_developments_blueprint_images();
    }

    /**
     * Get real estate development blueprint typologies.
     *
     * @return BelongsToMany
     */
    public function real_estate_developments_typologies(): BelongsToMany
    {
        return $this->belongsToMany(Typology::class, config('sp-produto.table_prefix') . 'blueprint_typology');
    }
}

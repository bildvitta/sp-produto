<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
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
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('blueprints');
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
            Accessory::class,
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
}

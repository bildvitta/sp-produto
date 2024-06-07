<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\AccessoryFactory;
use BildVitta\SpProduto\Models\Accessory as BaseAccessory;
use BildVitta\SpProduto\Models\AccessoryCategory;
use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Accessory.
 */
class Accessory extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'real_estate_development_accessories';
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return AccessoryFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'accessory_id',
        'personalization',
        'stock_quantity',
        'start_at',
        'end_at',
        'order',
        'accessory_category_id',
        'category_id',
        'real_estate_development_id',
        'all_typologies',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function name(): BelongsTo
    {
        return $this->accessory();
    }

    /**
     * Define Accessory
     */
    public function accessory(): BelongsTo
    {
        return $this->belongsTo(BaseAccessory::class);
    }

    /**
     * Define an inverse one-to-one or many relationship.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AccessoryCategory::class, 'accessory_category_id', 'id');
    }

    /**
     * Real Estate Development accessory categorization.
     */
    public function accessory_categorization(): BelongsTo
    {
        return $this->belongsTo(AccessoryCategory::class);
    }

    public function real_estate_development(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }

    public function unities()
    {
        return $this->belongsToMany(Unit::class, prefixTableName('real_estate_development_accessory_unit'));
    }

    public function getNameAttribute(): ?string
    {
        return $this?->accessory?->name;
    }
}

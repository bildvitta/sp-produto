<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\SpProduto\Factories\PersonalizationFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Characteristic.
 */
class Personalization extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'personalizations';
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return PersonalizationFactory::new();
    }

    /**'
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'value',
        'description',
        'is_active',
        'real_estate_development_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value' => 'decimal:2',
    ];

    /**
     * Personalization environment
     */
    public function environments(): BelongsToMany
    {
        return $this->belongsToMany(Environment::class, prefixTableName('environment_personalization'));
    }

    /**
     * Personalization development
     */
    public function real_estate_development(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }
}

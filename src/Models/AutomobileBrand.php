<?php

namespace BildVitta\SpProduto\Models;

use Bildvitta\SpProduto\Models\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutomobileBrand extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public const AUTO_TYPES = [
        'car' => 'Carro',
        'bike' => 'Moto',
    ];

    protected $fillable = [
        'uuid',
        'type',
        'label',
        'slug',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'automobile_brands';
    }

    public function models(): HasOne
    {
        return $this->hasOne(AutomobileModel::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'brand_id', 'id');
    }
}

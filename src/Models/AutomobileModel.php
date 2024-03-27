<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutomobileModel extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'automobile_brand_id',
        'uuid',
        'label',
        'slug',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'automobile_models';
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(AutomobileBrand::class, 'automobile_brand_id');
    }

    public function versions(): HasOne
    {
        return $this->hasOne(AutomobileVersion::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'model_id', 'id');
    }
}

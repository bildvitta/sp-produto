<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutomobileVersion extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'automobile_model_id',
        'uuid',
        'label',
        'slug',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'automobile_versions';
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(AutomobileModel::class, 'automobile_model_id');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'version_id', 'id');
    }
}

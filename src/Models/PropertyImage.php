<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyImage extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    /**'
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'image',
        'format',
        'property_id',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'property_images';
    }

    /**
     * Get the image property
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}

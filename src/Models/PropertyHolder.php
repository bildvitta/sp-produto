<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyHolder extends BaseModel
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'holder_property';

    protected $fillable = [
        'property_id',
        'holder_uuid',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'holder_property';
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}

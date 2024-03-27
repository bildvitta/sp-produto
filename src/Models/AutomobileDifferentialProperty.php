<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomobileDifferentialProperty extends Model
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'automobile_differential_property';
    }

    protected $fillable = [
        'automobile_differential_id',
        'property_id',
    ];

    public function automobile_differential()
    {
        return $this->belongsTo(AutomobileDifferential::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateDifferentialProperty extends Model
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
        $this->table = config('sp-produto.table_prefix').'estate_differential_property';
    }

    protected $fillable = [
        'estate_differential_id',
        'property_id',
    ];

    public function estate_differential()
    {
        return $this->belongsTo(EstateDifferential::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

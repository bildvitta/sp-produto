<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstateDifferential extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'label',
        'slug',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'estate_differential_property';
    }
}

<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutomobileDifferential extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'label',
        'value',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'automobile_differentials';
    }
}

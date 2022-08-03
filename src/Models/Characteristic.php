<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Characteristic.
 *
 * @package BildVitta\SpProduto\Models
 */
class Characteristic extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('characteristics');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'icon',
    ];
}

<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Mirror.
 *
 * @package BildVitta\SpProduto\Models
 */
class MirrorGroup extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('mirror_groups');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'mirror_id'
    ];

    /**
     * @return BelongsTo
     */
    public function mirror(): BelongsTo
    {
        return $this->belongsTo(Mirror::class);
    }
}
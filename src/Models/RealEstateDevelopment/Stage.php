<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Stage.
 *
 * @package BildVitta\SpProduto\Models
 */
class Stage extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('stages');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'registered_at',
        'foundation',
        'masonry',
        'structure',
        'finishing',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'foundation' => 'integer',
        'masonry' => 'integer',
        'structure' => 'integer',
        'finishing' => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }
}

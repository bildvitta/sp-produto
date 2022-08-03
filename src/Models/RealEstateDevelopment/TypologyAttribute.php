<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProposalModel.
 *
 * @package BildVitta\SpProduto\Models
 */
class TypologyAttribute extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('typology_attribute');
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
        'type_increase',
        'value_increase',
    ];

    /**
     * @return BelongsTo
     */
    public function typology(): BelongsTo
    {
        return $this->belongsTo(Typology::class);
    }
}

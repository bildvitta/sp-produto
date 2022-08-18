<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProposalModel.
 *
 * @package BildVitta\SpProduto\Models
 */
class Typology extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('typologies');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'real_estate_development_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function proposal_model(): BelongsTo
    {
        return $this->belongsTo(ProposalModel::class, prefixTableName('proposal_models'));
    }

    /**
     * @return BelongsTo
     */
    public function real_estate_development(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class, prefixTableName('real_estate_developments'));
    }
}

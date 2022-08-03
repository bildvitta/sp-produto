<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProposalModel.
 *
 * @package BildVitta\SpProduto\Models
 */
class ProposalModel extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('proposal_models');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
    ];
}

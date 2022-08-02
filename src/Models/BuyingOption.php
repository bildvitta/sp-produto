<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BuyingOption.
 *
 * @package BildVitta\SpProduto\Models
 */
class BuyingOption extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = sprintf('%sbuying_options', config('sp-produto.table_prefix'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'income_commitment',
        'name',
        'when_flow_sent',
        'when_flow_validated',
        'when_make_sale',
        'when_reserve_unit',
        'hub_company_id',
    ];
}

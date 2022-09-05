<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\SpProduto\Factories\BuyingOptionFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BuyingOption.
 *
 * @package BildVitta\SpProduto\Models
 */
class BuyingOption extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix') . 'buying_options';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return BuyingOptionFactory::new();
    }

    public const WHEN_FLOW_SENT_LIST = [
        'without_restriction' => 'Sem restrição',
        'after_cadastral_analysis' => 'Após análise cadastral',
        'after_credit_approval' => 'Após aprovação de crédito',
        'after_bank_approval' => 'Após aprovação do banco',
    ];

    public const WHEN_FLOW_VALIDATED_LIST = [
        'without_restriction' => 'Sem restrição',
        'after_cadastral_analysis' => 'Após análise cadastral',
        'after_credit_approval' => 'Após aprovação de crédito',
        'after_bank_approval' => 'Após aprovação do banco',
    ];

    public const WHEN_MAKE_SALE_LIST = [
        'without_restriction' => 'Sem restrição',
        'after_cadastral_analysis' => 'Após análise cadastral',
        'after_credit_approval' => 'Após aprovação de crédito',
        'after_bank_approval' => 'Após aprovação do banco',
    ];

    public const WHEN_RESERVE_UNIT_LIST = [
        'without_restriction' => 'Sem restrição',
        'after_cadastral_analysis' => 'Após análise cadastral',
        'after_credit_approval' => 'Após aprovação de crédito',
        'after_bank_approval' => 'Após aprovação do banco',
    ];

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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get hub company
     *
     * @return BelongsTo
     */
    public function hub_company(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_company'));
    }
}

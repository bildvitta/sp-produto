<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\ParameterFactory;
use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\BuyingOption;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Parameter.
 *
 * @package BildVitta\SpProduto\Models
 */
class Parameter extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix') . 'parameters';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return ParameterFactory::new();
    }

    public const COMMERCIALIZATION_STATUS_LIST = [
        'holding' => 'Aguardando',
        'in_commercialization' => 'Em comercialização',
        'ready_to_commercializate' => 'Pronto para comercialização',
    ];

    public const FINANCIAL_TRANSFER_STATUS_LIST = [
        'holding' => 'Aguardando',
        'in_transfer' => 'Em repasse',
    ];

    public const STEPS_LIST = [
        'pre_launch' => 'Pré-lançamento',
        'launch' => 'Lançamento',
        'under_construction' => 'Em construção',
        'ready_to_live' => 'Pronto para viver',
    ];

    public const VERGE_LIST = [
        '1' => 'Nível 1',
        '2' => 'Nível 2',
        '3' => 'Nível 3',
        '4' => 'Nível 4',
        '5' => 'Nível 5',
    ];

    public const REQUIRED_DATES = [
        'pre_launch_in',
        'launch_in',
        'blueprint_definition_deadline',
        'construction_over_in',
        'construction_start_in'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'allow_commercialization',
        'blueprint_definition_deadline',
        'commercialization_status',
        'construction_over_in',
        'construction_prevision_in',
        'construction_start_in',
        'financial_transfer_deadline',
        'financial_transfer_status',
        'hand_over_keys_in',
        'in_financial_transfer',
        'launch_in',
        'name',
        'pre_launch_in',
        'ready_to_live_in',
        'square_meter_price',
        'steps',
        'verge',
        'real_estate_development_id',
        'buying_option_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dates = [
        'blueprint_definition_deadline',
        'construction_over_in',
        'construction_prevision_in',
        'construction_start_in',
        'financial_transfer_deadline',
        'launch_in',
        'pre_launch_in',
        'ready_to_live_in',
        'hand_over_keys_in',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'allow_commercialization' => 'boolean',
        'in_financial_transfer' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }

    /**
     * Get the buying options for the parameter.
     *
     * @return BelongsToMany
     */
    public function buying_options(): BelongsToMany
    {
        return $this->belongsToMany(BuyingOption::class, config('sp-produto.prefix_table') . 'buying_options');
    }
}

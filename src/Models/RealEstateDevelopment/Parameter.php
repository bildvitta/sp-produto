<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Parameter.
 *
 * @package BildVitta\SpProduto\Models
 */
class Parameter extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('parameters');
    }

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
        'pre_launch_in',
        'ready_to_live_in',
        'square_meter_price',
        'steps',
        'verge',
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
}

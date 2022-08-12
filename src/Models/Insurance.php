<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Insurance.
 *
 * @package BildVitta\SpProduto\Models
 */
class Insurance extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('insurances');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'rate',
        'external_code',
        'is_active',
        'insurance_company_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'rate' => 'double',
    ];

    /**
     * Get insurance company.
     *
     * @return BelongsTo
     */
    public function insuranceCompanies(): BelongsTo
    {
        return $this->belongsTo(InsuranceCompany::class);
    }
}

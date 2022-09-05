<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\SpProduto\Factories\InsuranceFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Insurance.
 *
 * @package BildVitta\SpProduto\Models
 */
class Insurance extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix') . 'insurances';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return InsuranceFactory::new();
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
        'created_at',
        'updated_at',
        'deleted_at',
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

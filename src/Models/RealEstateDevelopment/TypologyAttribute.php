<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\TypologyAttributeFactory;
use BildVitta\SpProduto\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProposalModel.
 *
 * @package BildVitta\SpProduto\Models
 */
class TypologyAttribute extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix') . 'typology_attributes';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return TypologyAttributeFactory::new();
    }

    /**
     * Tipo de acréscimo.
     *
     * @const array[]
     */
    public const ADDITION_TYPE = [
        'fixed_value' => 'Valor fixo',
        'addition_value' => 'Acréscimo de valor',
        'percentage' => 'Percentual'
    ];

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
        'typology_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function typology(): BelongsTo
    {
        return $this->belongsTo(Typology::class);
    }
}

<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\SpProduto\Factories\AttributeFactory;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'attributes';
    }

    protected static function newFactory(): Factory
    {
        return AttributeFactory::new();
    }

    public const ADDITION_TYPE = [
        'fixed_value' => 'Valor fixo',
        'addition_value' => 'Acréscimo de valor',
        'percentage' => 'Percentual',
    ];

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'type_increase',
        'value_increase',
        'hub_company_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function hub_company(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_company'), 'hub_company_id', 'id');
    }

    public function typologies(): BelongsToMany
    {
        return $this->belongsToMany(Typology::class, prefixTableName('attribute_typology'), 'attribute_id', 'typology_id');
    }
}

<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\TypologyFactory;
use BildVitta\SpProduto\Models\Attribute;
use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Typology extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'real_estate_development_id',
        'extract_text',
        'itbi_value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'itbi_value' => 'real',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'typologies';
    }

    protected static function newFactory(): Factory
    {
        return TypologyFactory::new();
    }

    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }

    public function real_estate_developments_proposal_model(): BelongsToMany
    {
        return $this->belongsToMany(ProposalModel::class, config('sp-produto.table_prefix').'proposal_model_typology', 'typology_id', 'proposal_model_id');
    }

    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(RealEstateDevelopment\Accessory::class, config('sp-produto.table_prefix').'real_estate_development_accessory_typology');
    }

    public function blueprints(): BelongsToMany
    {
        return $this->belongsToMany(Blueprint::class, config('sp-produto.table_prefix').'blueprint_typology')
            ->with('real_estate_developments_blueprint_images');
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function typology_attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, prefixTableName('attribute_typology'), 'typology_id', 'attribute_id');
    }
}

<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\MirrorFactory;
use BildVitta\SpProduto\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Mirror.
 */
class Mirror extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'mirrors';
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return MirrorFactory::new();
    }

    /**
     * Mirror types.
     *
     * @const array
     */
    public const MIRROR_TYPES = [
        'horizontal' => 'Horizontal',
        'vertical' => 'Vertical',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'mirror_type',
        'real_estate_development_id',
        'parameter_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Define a one-to-one relationship.
     */
    public function real_estate_developments_parameters(): BelongsTo
    {
        return $this->belongsTo(Parameter::class, 'parameter_id');
    }

    public function subgroups(): Collection
    {
        return $this->mirrorGroup()->with([
            'units' => function (HasMany $query) {
                $query->with(['real_estate_developments_blueprints']);
                $query->orderBy('floor');
            },
        ])->get();
    }

    /**
     * Define a one-to-many relationship.
     */
    public function mirrorGroup(): HasMany
    {
        return $this->real_estate_developments_mirrors_subgroups();
    }

    /**
     * Define a one-to-many relationship.
     */
    public function real_estate_developments_mirrors_subgroups(): HasMany
    {
        return $this->hasMany(MirrorGroup::class);
    }
}

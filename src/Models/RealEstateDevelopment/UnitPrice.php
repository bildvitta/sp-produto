<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\UnitFactory;
use BildVitta\SpProduto\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int $unit_id
 * @property \Illuminate\Support\Carbon $period
 * @property string $fixed_price
 * @property string $table_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Entities\RealEstateDevelopment\Unit $unit
 *
 * @method static \Database\Factories\Entities\RealEstateDevelopment\UnitPriceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice newQuery()
 * @method static Builder|UnitPrice pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice query()
 * @method static Builder|UnitPrice search()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice whereFixedPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice whereTablePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitPrice whereUuid($value)
 *
 * @mixin \Eloquent
 */
class UnitPrice extends BaseModel
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'unit_prices';
    }

    protected static function newFactory(): Factory
    {
        return UnitFactory::new();
    }

    protected $fillable = [
        'uuid',
        'unit_id',
        'period',
        'fixed_price',
        'table_price',
    ];

    protected $casts = [
        'period' => 'date',
        'fixed_price' => 'decimal:3',
        'table_price' => 'decimal:3',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}

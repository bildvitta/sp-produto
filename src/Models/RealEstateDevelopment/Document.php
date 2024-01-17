<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\DocumentFactory;
use BildVitta\SpProduto\Models\BaseModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Document.
 *
 * @package BildVitta\SpProduto\Models
 */
class Document extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @const array
     */
    public const TYPE_LIST = [
        'others' => 'Outros',
        'descriptive_memorial' => 'Memorial Descritivo',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'format',
        'preview',
        'url',
        'active',
        'real_estate_development_id',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts = ['active' => 'boolean'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix') . 'documents';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return DocumentFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }
}

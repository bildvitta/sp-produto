<?php

namespace BildVitta\SpProduto\Models\RealEstateDevelopment;

use BildVitta\SpProduto\Factories\RealEstateDevelopment\MediaFactory;
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
class Media extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix') . 'media';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return MediaFactory::new();
    }

    /**
     * @const array MEDIA_TYPE_LIST
     */
    public const MEDIA_TYPE_LIST = [
        'image' => 'Imagem',
        'video' => 'Vídeo',
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
        'preview',
        'media_type',
        'format',
        'url',
        'active',
        'real_estate_development_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['active' => 'boolean'];

    /**
     * @return BelongsTo
     */
    public function realEstateDevelopment(): BelongsTo
    {
        return $this->belongsTo(RealEstateDevelopment::class);
    }
}

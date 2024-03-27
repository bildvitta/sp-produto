<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use League\MimeTypeDetection\ExtensionMimeTypeDetector;

class PropertyAttachment extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'url',
        'format',
        'property_id',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'property_attachments';
    }

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model->format = (new ExtensionMimeTypeDetector)->detectMimeTypeFromPath(strtok($model->url, '?'));
        });
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}

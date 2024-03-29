<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel.
 */
class BaseModel extends Model
{
    /**
     * @const string
     */
    protected const KEY_UUID = 'uuid';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return self::KEY_UUID;
    }
}

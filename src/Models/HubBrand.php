<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\Hub\Entities\HubBrand as BaseHubBrand;
use Illuminate\Database\Eloquent\SoftDeletes;

class HubBrand extends BaseHubBrand
{
    use SoftDeletes;
}

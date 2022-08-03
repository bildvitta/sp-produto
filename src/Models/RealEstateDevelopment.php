<?php

namespace BildVitta\SpProduto\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RealEstateDevelopment.
 *
 * @package BildVitta\SpProduto\Models
 */
class RealEstateDevelopment extends BaseModel
{
    use SoftDeletes;

    public function __construct()
    {
        parent::__construct();
        $this->table = prefixTableName('real_estate_developments');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'status',
        'address',
        'city',
        'complement',
        'construction_address',
        'construction_city',
        'construction_complement',
        'construction_neighborhood',
        'construction_phone',
        'construction_postal_code',
        'construction_state',
        'construction_street_number',
        'description',
        'document',
        'latitude',
        'longitude',
        'legal_text',
        'name',
        'neighborhood',
        'nickname',
        'nire',
        'nire_date',
        'postal_code',
        'real_estate',
        'real_estate_logo',
        'register_number',
        'registration_number',
        'registry_office',
        'state',
        'street_number',
        'has_empty_fields',
        'hub_company_id',
        'external_code',
        'external_num_code',
        'external_company_code',
        'external_subsidiary_code',
        'real_estate_development_type_id',
    ];
}

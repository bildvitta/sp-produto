<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\SpProduto\Traits\HasStates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends BaseModel
{
    use HasFactory;
    use HasStates;
    use SoftDeletes;

    public const KIND_LIST = [
        'estates' => 'Imóvel',
        'automobile' => 'Automóvel',
        'other' => 'Outro',
    ];

    public const ESTATE_TYPE_LIST = [
        'house' => 'Casa',
        'apartment' => 'Apartamento',
        'commercial' => 'Comercial',
        'rural' => 'Rural',
    ];

    public const PROPERTY_CONDITION = [
        'new' => 'Novo',
        'used' => 'Usado',
    ];

    public const BODY_TYPE_LIST = [
        'hatch' => 'Hatch',
        'sedan' => 'Sedan',
    ];

    public const AUTOMOBILE_TYPE_LIST = [
        'car' => 'Carro',
        'bike' => 'Moto',
    ];

    public const FUEL_LIST = [
        'flex' => 'Flex',
        'gas' => 'Gasolina',
        'ethanol' => 'Etanol',
        'diesel' => 'Diesel',
    ];

    public const BASE_COLOR_LIST = [
        'white' => 'Branco',
        'black' => 'Preto',
        'silver' => 'Prata',
        'blue' => 'Azul',
        'red' => 'Vermelho',
    ];

    public const IPTU_PAYMENT_CONDITION = [
        'monthly' => 'Mensal',
        'yearly' => 'Anual',
        'free' => 'Isento',
    ];

    public const PROPERTY_STANDARD = [
        'high' => 'Alto',
        'low' => 'Baixo',
        'average' => 'Médio',
        'regular' => 'Regular',
    ];

    public const LOCATION_STANDARD = [
        'privileged' => 'Privilegiada',
        'excellent' => 'Ótima',
        'average' => 'Média',
        'regular' => 'Regular',
        'good' => 'Boa',
    ];

    public const PROPERTY_PURPOSE = [
        'residential' => 'Residencial',
        'commercial' => 'Commercial',
        'industrial' => 'Industrial',
        'rural' => 'Rural',
        'season' => 'Temporada',
        'corporate' => 'Corporativa',
    ];

    protected $fillable = [
        'uuid',
        'kind',
        'property_name',
        'description',
        'desired_value',
        'rated_price',
        'postal_code',
        'address',
        'number',
        'city',
        'state',
        'complement',
        'neighborhood',
        'estate_type',
        'property_condition',
        'useful_area',
        'total_area',
        'average_property_tax',
        'rooms_quantity',
        'suite_rooms_quantity',
        'bathrooms_quantity',
        'garage_quantity',
        'floor_number',
        'floors_quantity',
        'unities_floor_quantity',
        'is_condominium',
        'condominium_name',
        'average_condominium_price',
        'is_rented',
        'rental_price',
        'automobile_body_type',
        'automobile_type',
        'model_year',
        'fuel',
        'base_color',
        'commercial_color',
        'mileage',
        'hub_company_id',
        'sales_code',
        'property_purpose',
        'authorized_commercialization',
        'iptu_payment_condition',
        'property_standard',
        'location_standard',
        'construction_year',
        'property_renovation_year',
        'exclusivity',
        'accept_financing',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected $casts = [
        'is_condominium' => 'boolean',
        'is_rented' => 'boolean',
        'authorized_commercialization' => 'boolean',
        'exclusivity' => 'boolean',
        'accept_financing' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'properties';
    }

    public function hub_company(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_company'), 'hub_company_id', 'id');
    }

    /**
     * Get the automobile brand
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(AutomobileBrand::class, 'brand_id');
    }

    /**
     * Get the automobile model
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(AutomobileModel::class, 'model_id');
    }

    public function automobile_differentials(): BelongsToMany
    {
        return $this->belongsToMany(AutomobileDifferential::class, config('sp-produto.table_prefix') . 'automobile_differential_property', 'property_id', 'automobile_differential_id');
    }

    public function estates_differentials(): BelongsToMany
    {
        return $this->belongsToMany(EstateDifferential::class, config('sp-produto.table_prefix') . 'estate_differential_property', 'property_id', 'estate_differential_id');
    }

    /**
     * Get the automobile version
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(AutomobileVersion::class, 'version_id');
    }

    public function property_holders(): HasMany
    {
        return $this->hasMany(PropertyHolder::class);
    }

    public function property_images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function property_attachments(): HasMany
    {
        return $this->hasMany(PropertyAttachment::class);
    }
}

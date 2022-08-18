<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Document;
use BildVitta\SpProduto\Models\RealEstateDevelopment\MirrorGroup;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Stage;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Unit;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Mirror;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RealEstateDevelopment.
 *
 * @package BildVitta\SpProduto\Models
 */
class RealEstateDevelopment extends BaseModel
{
    use SoftDeletes;

    public const STATUS_LIST = [
        'incomplete_registration' => 'Cadastro incompleto',
        'ready_for_commercialization' => 'Pronto para comercialização',
        'in_commercialization' => 'Em comercialização',
    ];

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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get hub company.
     *
     * @return BelongsTo
     */
    public function hub_company(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_company'));
    }

    /**
     * Real estate developments proposal models.
     */
    public function proposal_models()
    {
        return $this->belongsToMany(ProposalModel::class, prefixTableName('proposal_model_real_estate_development'));
    }

    /**
     * Real estate developments buying options.
     */
    public function buying_options()
    {
        return $this->belongsToMany(BuyingOption::class, prefixTableName('buying_option_real_estate_development'));
    }

    /**
     * Real estate development insurance companies.
     */
    public function insurance_companies()
    {
        return $this->belongsToMany(InsuranceCompany::class, prefixTableName('insurance_company_real_estate_development'));
    }

    /**
     * Real estate development insurances.
     */
    public function insurances()
    {
        return $this->belongsToMany(Insurance::class, prefixTableName('insurance_real_estate_development'));
    }

    /**
     * Real estate development characteristics.
     */
    public function characteristics()
    {
        return $this->belongsTo(Characteristic::class);
    }

    /**
     * Real estate development groups.
     */
    public function groups()
    {
        return $this->belongsTo(MirrorGroup::class);
    }

    /**
     * Real estate development stages.
     */
    public function stages()
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Real estate development documents.
     */
    public function documents()
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Real estate developments unities.
     */
    public function unities()
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Real estate developments mirrors.
     */
    public function mirrors()
    {
        return $this->hasMany(Mirror::class);
    }
}

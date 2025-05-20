<?php

namespace BildVitta\SpProduto\Models;

use BildVitta\SpProduto\Factories\RealEstateDevelopmentFactory;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Blueprint;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Characteristic;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Document;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Media;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Mirror;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Parameter;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Stage;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Unit;
use BildVitta\SpProduto\Scopes\RealEstateDevelopments\CompanyScope;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class RealEstateDevelopment.
 */
class RealEstateDevelopment extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_LIST = [
        'incomplete_registration' => 'Cadastro incompleto',
        'ready_for_commercialization' => 'Pronto para comercialização',
        'in_commercialization' => 'Em comercialização',
    ];

    /**
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
        'hub_company_real_estate_agency_id',
        'external_code',
        'external_num_code',
        'external_company_code',
        'external_subsidiary_code',
        'real_estate_development_type_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'registration',
        'real_estate_development_code',
        'extract_text',
        'segment',
        'brand_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('sp-produto.table_prefix').'real_estate_developments';
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_brand'), 'brand_id', 'id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return RealEstateDevelopmentFactory::new();
    }

    /**
     * Real estate developments hub company
     */
    public function hub_company(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_company'));
    }

    /**
     * Real estate developments hub company
     */
    public function real_estate_agency(): BelongsTo
    {
        return $this->belongsTo(config('sp-produto.model_company'), 'hub_company_real_estate_agency_id');
    }

    /**
     * Real estate developments proposal models
     */
    public function proposal_models(): BelongsToMany
    {
        return $this->belongsToMany(ProposalModel::class, config('sp-produto.table_prefix').'proposal_model_real_estate_development')
            ->with('periodicities');
    }

    /**
     * Real estate developments buying options
     */
    public function buying_options(): BelongsToMany
    {
        return $this->belongsToMany(BuyingOption::class, config('sp-produto.table_prefix').'buying_option_real_estate_development');
    }

    /**
     * Real estate development insurance companies
     */
    public function insurance_companies(): BelongsToMany
    {
        return $this->belongsToMany(InsuranceCompany::class, config('sp-produto.table_prefix').'insurance_company_real_estate_development');
    }

    /**
     * Real estate development insurances
     */
    public function insurances(): BelongsToMany
    {
        return $this->belongsToMany(Insurance::class, config('sp-produto.table_prefix').'insurance_real_estate_development');
    }

    /**
     * Real estate developments characteristics
     */
    public function characteristics(): HasMany
    {
        return $this->hasMany(Characteristic::class);
    }

    /**
     * Real estate developments accessories
     */
    public function accessories(): HasMany
    {
        return $this->hasMany(RealEstateDevelopment\Accessory::class);
    }

    /**
     * Real estate developments documents
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Real estate developments medias
     */
    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function lastStages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

    /**
     * Real estate developments typologies
     */
    public function typologies(): HasMany
    {
        return $this->hasMany(Typology::class);
    }

    /**
     * Real estate developments mirrors
     */
    public function mirrors(): HasMany
    {
        return $this->hasMany(Mirror::class);
    }

    /**
     * Define a one-to-many relationship.
     */
    public function unities(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Define a one-to-many relationship.
     */
    public function blueprints(): HasMany
    {
        return $this->hasMany(Blueprint::class);
    }

    public function getLaunchInAttribute()
    {
        if ($parameter = $this->parameters()->latest('created_at')->first()) {
            if ($parameter->launch_in) {
                return $parameter->launch_in;
            }
        }

        return null;
    }

    /**
     * Real estate developments paramenters
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class);
    }

    public function getPreLaunchInAttribute()
    {
        if ($parameter = $this->parameters()->latest('created_at')->first()) {
            if ($parameter->pre_launch_in) {
                if ($parameter->pre_launch_in->gt(Carbon::now())) {
                    return $parameter->pre_launch_in;
                }
            }
        }

        return null;
    }

    public function last_stage()
    {
        try {
            return $this->stages()->with(['images'])->latest('registered_at')->firstOrFail();
        } catch (ModelNotFoundException $modelNotFoundException) {
            return null;
        }
    }

    /**
     * Real estate developments stages
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

    public function last_parameter()
    {
        try {
            return $this->parameters()->latest('created_at')->firstOrFail();
        } catch (ModelNotFoundException $modelNotFoundException) {
            return null;
        }
    }

    public function real_estate_proposal_models()
    {
        return $this->proposal_models;
    }

    public function real_estate_accessories()
    {
        return $this->accessories()
            ->with(['accessory_categorization', 'accessory'])
            ->get()
            ->toArray();
    }

    public function getHubCompanyUuidAttribute(): ?string
    {
        return $this->hub_company?->uuid;
    }

    public function sellable_by(): BelongsToMany
    {
        return $this->belongsToMany(app(config('sp-produto.model_company')), config('sp-produto.table_prefix').'real_estate_development_companies', 'real_estate_development_id', 'hub_company_id')->withTimestamps();
    }
}

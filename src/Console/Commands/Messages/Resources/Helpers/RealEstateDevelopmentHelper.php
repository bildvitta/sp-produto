<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Console\Commands\Messages\Exceptions\MessageProcessorException;
use BildVitta\SpProduto\Events\RealEstateDevelopments\RealEstateDevelopmentUpdated;
use BildVitta\SpProduto\Models\HubBrand;
use BildVitta\SpProduto\Models\HubCompany;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait RealEstateDevelopmentHelper
{
    /**
     * @throws MessageProcessorException
     */
    private function realEstateDevelopmentUpdateOrCreate(stdClass $message): void
    {
        $realEstateDevelopment = $this->getRealEstateDevelopment($message);

        $this->realEstateDevelopment($realEstateDevelopment, $message);

        if (isset($message->stages) && $this->configHas('stages')) {
            $this->stages($realEstateDevelopment, $message);
        }
        if (isset($message->parameters) && $this->configHas('parameters')) {
            $this->parameters($realEstateDevelopment, $message);
        }
        if (isset($message->insurances[0], $message->insurance_companies[0]) && $this->configHas('insurances')) {
            $this->insurances($realEstateDevelopment, $message);
        }
        if (isset($message->real_estate_proposal_models) && $this->configHas('proposal_models')) {
            $this->proposalModels($realEstateDevelopment, $message);
        }
        if (isset($message->buying_options) && $this->configHas('buying_options')) {
            $this->buyingOptions($realEstateDevelopment, $message);
        }
        if (isset($message->typologies) && $this->configHas('typologies')) {
            $this->typologies($realEstateDevelopment, $message);
        }
        if (isset($message->mirrors) && $this->configHas('mirrors')) {
            $this->mirrors($realEstateDevelopment, $message);
        }
        if (isset($message->accessories) && $this->configHas('accessories')) {
            $this->accessories($realEstateDevelopment, $message);
        }
        if (isset($message->blueprints) && $this->configHas('blueprints')) {
            $this->blueprints($realEstateDevelopment, $message);
        }
        if (isset($message->medias) && $this->configHas('media')) {
            $this->medias($realEstateDevelopment, $message);
        }
        if (isset($message->documents) && $this->configHas('documents')) {
            $this->documents($realEstateDevelopment, $message);
        }
        if (isset($message->sellable_by)) {
            $this->sellableBy($realEstateDevelopment, $message);
        }
        if (config('sp-produto.events.real_estate_development_updated')) {
            event(new RealEstateDevelopmentUpdated($message->uuid));
        }
    }

    private function realEstateDevelopmentDelete(stdClass $message): void
    {
        RealEstateDevelopment::where('uuid', $message->uuid)->delete();

        if (config('sp-produto.events.real_estate_development_updated')) {
            event(new RealEstateDevelopmentUpdated($message->uuid));
        }
    }

    private function getRealEstateDevelopment(stdClass $message): RealEstateDevelopment
    {
        $realEstateDevelopment = RealEstateDevelopment::where('uuid', $message->uuid)->first();
        if (! $realEstateDevelopment) {
            $realEstateDevelopment = new RealEstateDevelopment;
            $realEstateDevelopment->uuid = $message->uuid;
            $realEstateDevelopment->hub_company_id = $this->getHubCompanyId($message->hub_company_uuid);
            $realEstateDevelopment->hub_company_real_estate_agency_id = $this->getHubCompanyId($message->hub_company_real_estate_agency_uuid);
            $realEstateDevelopment->save();
        }

        return $realEstateDevelopment;
    }

    private function realEstateDevelopment(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        if (property_exists($message, 'status')) {
            $realEstateDevelopment->status = $message->status;
        }
        if (property_exists($message, 'address')) {
            $realEstateDevelopment->address = $message->address;
        }
        if (property_exists($message, 'city')) {
            $realEstateDevelopment->city = $message->city;
        }
        if (property_exists($message, 'complement')) {
            $realEstateDevelopment->complement = $message->complement;
        }
        if (property_exists($message, 'construction_address')) {
            $realEstateDevelopment->construction_address = $message->construction_address;
        }
        if (property_exists($message, 'construction_city')) {
            $realEstateDevelopment->construction_city = $message->construction_city;
        }
        if (property_exists($message, 'construction_complement')) {
            $realEstateDevelopment->construction_complement = $message->construction_complement;
        }
        if (property_exists($message, 'construction_neighborhood')) {
            $realEstateDevelopment->construction_neighborhood = $message->construction_neighborhood;
        }
        if (property_exists($message, 'construction_phone')) {
            $realEstateDevelopment->construction_phone = $message->construction_phone;
        }
        if (property_exists($message, 'construction_postal_code')) {
            $realEstateDevelopment->construction_postal_code = $message->construction_postal_code;
        }
        if (property_exists($message, 'construction_state')) {
            $realEstateDevelopment->construction_state = $message->construction_state;
        }
        if (property_exists($message, 'construction_street_number')) {
            $realEstateDevelopment->construction_street_number = $message->construction_street_number;
        }
        if (property_exists($message, 'description')) {
            $realEstateDevelopment->description = $message->description;
        }
        if (property_exists($message, 'document')) {
            $realEstateDevelopment->document = $message->document;
        }
        if (property_exists($message, 'latitude')) {
            $realEstateDevelopment->latitude = $message->latitude;
        }
        if (property_exists($message, 'longitude')) {
            $realEstateDevelopment->longitude = $message->longitude;
        }
        if (property_exists($message, 'legal_text')) {
            $realEstateDevelopment->legal_text = $message->legal_text;
        }
        if (property_exists($message, 'name')) {
            $realEstateDevelopment->name = $message->name;
        }
        if (property_exists($message, 'neighborhood')) {
            $realEstateDevelopment->neighborhood = $message->neighborhood;
        }
        if (property_exists($message, 'nickname')) {
            $realEstateDevelopment->nickname = $message->nickname;
        }
        if (property_exists($message, 'nire')) {
            $realEstateDevelopment->nire = $message->nire;
        }
        if (property_exists($message, 'nire_date')) {
            $realEstateDevelopment->nire_date = $message->nire_date;
        }
        if (property_exists($message, 'postal_code')) {
            $realEstateDevelopment->postal_code = $message->postal_code;
        }
        if (property_exists($message, 'real_estate')) {
            $realEstateDevelopment->real_estate = $message->real_estate;
        }
        if (property_exists($message, 'real_estate_logo')) {
            $realEstateDevelopment->real_estate_logo = $message->real_estate_logo;
        }
        if (property_exists($message, 'register_number')) {
            $realEstateDevelopment->register_number = $message->register_number;
        }
        if (property_exists($message, 'registration_number')) {
            $realEstateDevelopment->registration_number = $message->registration_number;
        }
        if (property_exists($message, 'registry_office')) {
            $realEstateDevelopment->registry_office = $message->registry_office;
        }
        if (property_exists($message, 'registration')) {
            $realEstateDevelopment->registration = $message->registration;
        }
        if (property_exists($message, 'real_estate_development_code')) {
            $realEstateDevelopment->real_estate_development_code = $message->real_estate_development_code;
        }
        if (property_exists($message, 'extract_text')) {
            $realEstateDevelopment->extract_text = $message->extract_text;
        }
        if (property_exists($message, 'state')) {
            $realEstateDevelopment->state = $message->state;
        }
        if (property_exists($message, 'street_number')) {
            $realEstateDevelopment->street_number = $message->street_number;
        }
        if (property_exists($message, 'has_empty_fields')) {
            $realEstateDevelopment->has_empty_fields = $message->has_empty_fields;
        }
        if (property_exists($message, 'external_code')) {
            $realEstateDevelopment->external_code = $message->external_code;
        }
        if (property_exists($message, 'external_num_code')) {
            $realEstateDevelopment->external_num_code = $message->external_num_code;
        }
        if (property_exists($message, 'external_company_code')) {
            $realEstateDevelopment->external_company_code = $message->external_company_code;
        }
        if (property_exists($message, 'external_subsidiary_code')) {
            $realEstateDevelopment->external_subsidiary_code = $message->external_subsidiary_code;
        }
        if (property_exists($message, 'real_estate_development_type_id')) {
            $realEstateDevelopment->real_estate_development_type_id = $message->real_estate_development_type_id;
        }
        if (property_exists($message, 'segment')) {
            $realEstateDevelopment->segment = $message->segment;
        }
        if (property_exists($message, 'brand')) {
            $realEstateDevelopment->brand_id = $this->getBrandId($message->brand);
        }

        $realEstateDevelopment->hub_company_id = $this->getHubCompanyId($message->hub_company_uuid);
        $realEstateDevelopment->hub_company_real_estate_agency_id = $this->getHubCompanyId($message->hub_company_real_estate_agency_uuid);

        $realEstateDevelopment->save();
    }

    private function getBrandId(?string $hubBrandUuid): ?int
    {
        if (!$hubBrandUuid) {
            return null;
        }
        
        return HubBrand::withTrashed()
            ->where('uuid', $hubBrandUuid)
            ->first()
            ?->id;
    }

    private function getHubCompanyId(string $hubCompanyUuid): int
    {
        $hubCompany = HubCompany::withTrashed()
            ->where('uuid', $hubCompanyUuid)
            ->first();

        return $hubCompany->id;
    }
}

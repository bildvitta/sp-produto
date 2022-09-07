<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Console\Commands\Messages\Exceptions\MessageProcessorException;
use BildVitta\SpProduto\Models\HubCompany;
use stdClass;

trait RealEstateDevelopmentHelper
{
    /**
     * @param stdClass $message
     * @return void
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
    }

    /**
     * @param stdClass $message
     * @return void
     */
    private function realEstateDevelopmentDelete(stdClass $message): void
    {
        RealEstateDevelopment::where('uuid', $message->uuid)->delete();
    }

    /**
     * @param stdClass $message
     * @return RealEstateDevelopment
     */
    private function getRealEstateDevelopment(stdClass $message): RealEstateDevelopment
    {
        $realEstateDevelopment = RealEstateDevelopment::where('uuid', $message->uuid)->first();
        if (! $realEstateDevelopment) {
            $realEstateDevelopment = new RealEstateDevelopment();
            $realEstateDevelopment->uuid = $message->uuid;
            $realEstateDevelopment->hub_company_id = $this->getHubCompanyId($message->hub_company_uuid);
            $realEstateDevelopment->save();
        }

        return $realEstateDevelopment;
    }

    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function realEstateDevelopment(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        if (isset($message->status)) {
            $realEstateDevelopment->status = $message->status;
        }
        if (isset($message->address)) {
            $realEstateDevelopment->address = $message->address;
        }
        if (isset($message->city)) {
            $realEstateDevelopment->city = $message->city;
        }
        if (isset($message->complement)) {
            $realEstateDevelopment->complement = $message->complement;
        }
        if (isset($message->construction_address)) {
            $realEstateDevelopment->construction_address = $message->construction_address;
        }
        if (isset($message->construction_city)) {
            $realEstateDevelopment->construction_city = $message->construction_city;
        }
        if (isset($message->construction_complement)) {
            $realEstateDevelopment->construction_complement = $message->construction_complement;
        }
        if (isset($message->construction_neighborhood)) {
            $realEstateDevelopment->construction_neighborhood = $message->construction_neighborhood;
        }
        if (isset($message->construction_phone)) {
            $realEstateDevelopment->construction_phone = $message->construction_phone;
        }
        if (isset($message->construction_postal_code)) {
            $realEstateDevelopment->construction_postal_code = $message->construction_postal_code;
        }
        if (isset($message->construction_state)) {
            $realEstateDevelopment->construction_state = $message->construction_state;
        }
        if (isset($message->construction_street_number)) {
            $realEstateDevelopment->construction_street_number = $message->construction_street_number;
        }
        if (isset($message->description)) {
            $realEstateDevelopment->description = $message->description;
        }
        if (isset($message->document)) {
            $realEstateDevelopment->document = $message->document;
        }
        if (isset($message->latitude)) {
            $realEstateDevelopment->latitude = $message->latitude;
        }
        if (isset($message->longitude)) {
            $realEstateDevelopment->longitude = $message->longitude;
        }
        if (isset($message->legal_text)) {
            $realEstateDevelopment->legal_text = $message->legal_text;
        }
        if (isset($message->name)) {
            $realEstateDevelopment->name = $message->name;
        }
        if (isset($message->neighborhood)) {
            $realEstateDevelopment->neighborhood = $message->neighborhood;
        }
        if (isset($message->nickname)) {
            $realEstateDevelopment->nickname = $message->nickname;
        }
        if (isset($message->nire)) {
            $realEstateDevelopment->nire = $message->nire;
        }
        if (isset($message->nire_date)) {
            $realEstateDevelopment->nire_date = $message->nire_date;
        }
        if (isset($message->postal_code)) {
            $realEstateDevelopment->postal_code = $message->postal_code;
        }
        if (isset($message->real_estate)) {
            $realEstateDevelopment->real_estate = $message->real_estate;
        }
        if (isset($message->real_estate_logo)) {
            $realEstateDevelopment->real_estate_logo = $message->real_estate_logo;
        }
        if (isset($message->register_number)) {
            $realEstateDevelopment->register_number = $message->register_number;
        }
        if (isset($message->registration_number)) {
            $realEstateDevelopment->registration_number = $message->registration_number;
        }
        if (isset($message->registry_office)) {
            $realEstateDevelopment->registry_office = $message->registry_office;
        }
        if (isset($message->state)) {
            $realEstateDevelopment->state = $message->state;
        }
        if (isset($message->street_number)) {
            $realEstateDevelopment->street_number = $message->street_number;
        }
        if (isset($message->has_empty_fields)) {
            $realEstateDevelopment->has_empty_fields = $message->has_empty_fields;
        }
        if (isset($message->external_code)) {
            $realEstateDevelopment->external_code = $message->external_code;
        }
        if (isset($message->external_num_code)) {
            $realEstateDevelopment->external_num_code = $message->external_num_code;
        }
        if (isset($message->external_company_code)) {
            $realEstateDevelopment->external_company_code = $message->external_company_code;
        }
        if (isset($message->external_subsidiary_code)) {
            $realEstateDevelopment->external_subsidiary_code = $message->external_subsidiary_code;
        }
        if (isset($message->real_estate_development_type_id)) {
            $realEstateDevelopment->real_estate_development_type_id = $message->real_estate_development_type_id;
        }
        $realEstateDevelopment->save();
    }

    /**
     * @param string $hubCompanyUuid
     * @return int
     */
    private function getHubCompanyId(string $hubCompanyUuid): int
    {
        $hubCompany = HubCompany::withTrashed()
            ->where('uuid', $hubCompanyUuid)
            ->first();

        return $hubCompany->id;
    }
}

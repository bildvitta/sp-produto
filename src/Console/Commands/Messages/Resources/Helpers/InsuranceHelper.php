<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Insurance;
use BildVitta\SpProduto\Models\InsuranceCompany;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait InsuranceHelper
{
    private function insurances(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $insuranceCompany = InsuranceCompany::updateOrCreate([
            'uuid' => $message->insurance_companies[0]->uuid,
        ], [
            'uuid' => $message->insurance_companies[0]->uuid,
            'hub_company_id' => $this->hubCompanyId($message->insurance_companies[0]),
            'name' => $message->insurance_companies[0]->name,
            'company_name' => $message->insurance_companies[0]->company_name,
            'document' => $message->insurance_companies[0]->document,
            'susep' => $message->insurance_companies[0]->susep,
            'is_active' => $message->insurance_companies[0]->is_active,
        ]);

        $insurance = Insurance::updateOrCreate([
            'uuid' => $message->insurances[0]->uuid,
        ], [
            'uuid' => $message->insurances[0]->uuid,
            'name' => $message->insurances[0]->name,
            'insurance_company_id' => $insuranceCompany->id,
            'rate' => $message->insurances[0]->rate,
            'external_code' => $message->insurances[0]->external_code,
            'is_active' => $message->insurances[0]->is_active,
        ]);

        $realEstateDevelopment->insurance_companies()->sync($insuranceCompany);
        $realEstateDevelopment->insurances()->sync($insurance);
    }

    private function insuranceCompanyUpdateOrCreate(stdClass $message): void
    {
        $insuranceCompany = InsuranceCompany::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'name' => $message->name,
            'company_name' => $message->company_name,
            'document' => $message->document,
            'susep' => $message->susep,
            'is_active' => $message->is_active,
            'hub_company_id' => $this->hubCompanyId($message),
        ]);

        $insuranceIds = [];
        foreach($message->insurances as $messageInsurance) {
            $insurance = Insurance::updateOrCreate([
                'uuid' => $messageInsurance->uuid,
            ], [
                'uuid' => $messageInsurance->uuid,
                'name' => $messageInsurance->name,
                'insurance_company_id' => $insuranceCompany->id,
                'rate' => $messageInsurance->rate,
                'external_code' => $messageInsurance->external_code,
                'is_active' => $messageInsurance->is_active,
            ]);
            $insuranceIds[] = $insurance->id;
        }
        Insurance::where('insurance_company_id', $insuranceCompany->id)
            ->whereNotIn('id', $insuranceIds)
            ->delete();
    }

    private function insuranceCompanyDelete(stdClass $message): void
    {
        InsuranceCompany::where('uuid', $message->uuid)->delete();
    }
}

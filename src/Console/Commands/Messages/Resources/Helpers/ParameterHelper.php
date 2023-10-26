<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Parameter;
use stdClass;

trait ParameterHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function parameters(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $parameterIds = [];
        foreach ($message->parameters as $messageParameter) {
            $parameter = Parameter::updateOrCreate([
                'uuid' => $messageParameter->uuid,
            ], [
                'uuid' => $messageParameter->uuid,
                'allow_commercialization' => $messageParameter->allow_commercialization,
                'blueprint_definition_deadline' => $this->toCarbon($messageParameter->blueprint_definition_deadline),
                'buying_option_id' => $messageParameter->buying_option_id,
                'commercialization_status' => $messageParameter->commercialization_status,
                'construction_over_in' =>  $this->toCarbon($messageParameter->construction_over_in),
                'construction_prevision_in' => $this->toCarbon($messageParameter->construction_prevision_in),
                'construction_start_in' => $this->toCarbon($messageParameter->construction_start_in),
                'financial_transfer_deadline' => $this->toCarbon($messageParameter->financial_transfer_deadline),
                'financial_transfer_status' => $messageParameter->financial_transfer_status,
                'hand_over_keys_in' => $this->toCarbon($messageParameter->hand_over_keys_in),
                'in_financial_transfer' => $messageParameter->in_financial_transfer,
                'launch_in' => $this->toCarbon($messageParameter->launch_in),
                'name' => $messageParameter->name,
                'pre_launch_in' => $this->toCarbon($messageParameter->pre_launch_in),
                'ready_to_live_in' => $this->toCarbon($messageParameter->ready_to_live_in),
                'square_meter_price' => $messageParameter->square_meter_price,
                'steps' => $messageParameter->steps,
                'verge' => $messageParameter->verge,
                'verge_1' => $messageParameter->verge_1,
                'verge_2' => $messageParameter->verge_2,
                'verge_3' => $messageParameter->verge_3,
                'verge_4' => $messageParameter->verge_4,
                'verge_5' => $messageParameter->verge_5,
                'has_empty_fields' => $messageParameter->has_empty_fields,
                'real_estate_development_id' => $realEstateDevelopment->id,
            ]);
            $parameterIds[] = $parameter->id;
        }
        Parameter::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $parameterIds)
            ->delete();
    }
}

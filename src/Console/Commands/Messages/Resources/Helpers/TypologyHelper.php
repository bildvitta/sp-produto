<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
use BildVitta\SpProduto\Models\RealEstateDevelopment\TypologyAttribute;
use stdClass;

trait TypologyHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function typologies(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $typologyIds = [];
        foreach ($message->typologies as $messageTypology) {
            $typology = Typology::updateOrCreate([
                'uuid' => $messageTypology->uuid,
            ], [
                'uuid' => $messageTypology->uuid,
                'real_estate_development_id' => $realEstateDevelopment->id,
                'name' => $messageTypology->name,
            ]);
            $typologyIds[] = $typology->id;
            $this->typologyProposalModel($typology, $messageTypology);
            $this->typologyAttributes($typology, $messageTypology);
        }
        Typology::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $typologyIds)
            ->delete();
    }

    /**
     * @param Typology $typology
     * @param stdClass $messageTypology
     * @return void
     */
    private function typologyProposalModel(Typology $typology, stdClass $messageTypology): void
    {
        if (isset($messageTypology->proposal_models[0])) {
            if ($proposalModel = ProposalModel::where('uuid', $messageTypology->proposal_models[0]->uuid)->first()) {
                $typology->proposal_model_id = $proposalModel->id;
                $typology->save();
            }
        }
    }

    /**
     * @param Typology $typology
     * @param stdClass $messageTypology
     * @return void
     */
    private function typologyAttributes(Typology $typology, stdClass $messageTypology): void
    {
        $typologyAttributeIds = [];
        foreach ($messageTypology->attributes as $messageAttribute) {
            $typologyAttribute = TypologyAttribute::updateOrCreate([
                'uuid' => $messageAttribute->uuid,
            ], [
                'uuid' => $messageAttribute->uuid,
                'typology_id' => $typology->id,
                'name' => $messageAttribute->name,
                'description' => $messageAttribute->description,
                'type_increase' => $messageAttribute->type_increase,
                'value_increase' => $messageAttribute->value_increase,
            ]);
            $typologyAttributeIds[] = $typologyAttribute->id;
        }

        TypologyAttribute::where('typology_id', $typology->id)
            ->whereNotIn('id', $typologyAttributeIds)
            ->delete();
    }
}

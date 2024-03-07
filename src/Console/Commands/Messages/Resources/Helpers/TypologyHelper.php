<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
use BildVitta\SpProduto\Models\RealEstateDevelopment\TypologyAttribute;
use stdClass;

trait TypologyHelper
{
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
                'extract_text' => $messageTypology->extract_text,
                'itbi_value' => $messageTypology->itbi_value,
            ]);
            $typologyIds[] = $typology->id;
            $this->typologyProposalModel($typology, $messageTypology);
            $this->typologyAttributes($typology, $messageTypology);
        }
        Typology::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $typologyIds)
            ->delete();
    }

    private function typologyProposalModel(Typology $typology, stdClass $messageTypology): void
    {
        if (! empty($messageTypology->proposal_models)) {
            $proposalModelIds = [];
            foreach ($messageTypology->proposal_models as $proposal_model) {
                $proposalModelIds[] = ProposalModel::where('uuid', $proposal_model->uuid)->first()->id;
            }
            $typology->real_estate_developments_proposal_model()->sync($proposalModelIds);
        }
    }

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

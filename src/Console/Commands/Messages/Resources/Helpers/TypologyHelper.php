<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\Attribute;
use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
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
        $proposalModelUuids = collect($messageTypology->proposal_models)->pluck('uuid');
        $proposalModelIds = ProposalModel::whereIn('uuid', $proposalModelUuids)
            ->get(['id'])
            ->pluck('id')
            ->toArray();
        $typology->real_estate_developments_proposal_model()->sync($proposalModelIds);
    }

    private function typologyAttributes(Typology $typology, stdClass $messageTypology): void
    {
        $attributeIds = [];
        foreach ($messageTypology->attributes as $messageAttribute) {
            $attribute = Attribute::updateOrCreate([
                'uuid' => $messageAttribute->uuid,
            ], [
                'uuid' => $messageAttribute->uuid,
                'name' => $messageAttribute->name,
                'description' => $messageAttribute->description,
                'type_increase' => $messageAttribute->type_increase,
                'value_increase' => $messageAttribute->value_increase,
                'hub_company_id' => $this->hubCompanyId($messageAttribute),
            ]);
            $attributeIds[] = $attribute->id;
        }
        $typology->typology_attributes()->sync($attributeIds);
    }
}

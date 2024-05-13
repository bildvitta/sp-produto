<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\ProposalModel;
use BildVitta\SpProduto\Models\ProposalModelPeriodicities;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait ProposalModelHelper
{
    public function proposalModels(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $proposalModelIds = [];
        foreach ($message->real_estate_proposal_models as $messageProposalModel) {
            if ($proposalModelId = ProposalModel::where('uuid', $messageProposalModel->uuid)->value('id')) {
                $proposalModelIds[] = $proposalModelId;
            }
        }
        $realEstateDevelopment->proposal_models()->sync($proposalModelIds);
    }

    private function proposalModelUpdateOrCreate(stdClass $message): void
    {
        $proposalModel = ProposalModel::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'name' => $message->name,
            'hub_company_id' => $this->hubCompanyId($message),
        ]);
        $proposalModelPeriodicityIds = [];
        foreach ($message->periodicities as $periodicity) {
            $proposalModelPeriodicity = ProposalModelPeriodicities::updateOrCreate([
                'uuid' => $periodicity->uuid,
            ], [
                'uuid' => $periodicity->uuid,
                'update_installments_quantity' => $periodicity->update_installments_quantity,
                'installments' => $periodicity->installments,
                'periodicity' => $periodicity->periodicity,
                'periodicity_quantity' => $periodicity->periodicity_quantity,
                'pin_value' => $periodicity->pin_value,
                'add_on_type' => $periodicity->add_on_type,
                'add_on_value' => $periodicity->add_on_value,
                'proposal_model_id' => $proposalModel->id,
            ]);
            $proposalModelPeriodicityIds[] = $proposalModelPeriodicity->id;
        }
        ProposalModelPeriodicities::where('proposal_model_id', $proposalModel->id)
            ->whereNotIn('id', $proposalModelPeriodicityIds)
            ->delete();
    }

    private function proposalModelDelete(stdClass $message): void
    {
        ProposalModel::where('uuid', $message->uuid)->delete();
    }
}

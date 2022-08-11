<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Stage;
use BildVitta\SpProduto\Models\RealEstateDevelopment\StageImage;
use stdClass;
use Carbon\Carbon;

trait StageHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function stages(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $stageIds = [];
        foreach($message->stages as $messageStage) {
            $stage = Stage::updateOrCreate([
                'uuid' => $messageStage->uuid,
            ], [
                'uuid' => $messageStage->uuid,
                'name' => $messageStage->name,
                'registered_at' => Carbon::create($messageStage->registered_at),
                'foundation' => $messageStage->foundation,
                'masonry' => $messageStage->masonry,
                'structure' => $messageStage->structure,
                'finishing' => $messageStage->finishing,
                'real_estate_development_id' => $realEstateDevelopment->id, 
            ]);
            $this->stageImages($stage, $messageStage->images);
            $stageIds[] = $stage->id;
        }
        Stage::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $stageIds)
            ->delete();
    }

    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param array $messageStageImages
     * @return void
     */
    private function stageImages(Stage $stage, array $messageStageImages): void
    {
        $stageImageIds = [];
        foreach($messageStageImages as $messageStageImage) {
            $stageImage = StageImage::updateOrCreate([
                'uuid' => $messageStageImage->uuid,
            ], [
                'uuid' => $messageStageImage->uuid,
                'name' => $messageStageImage->name,
                'format' => $messageStageImage->format,
                'image' => $messageStageImage->image,
                'stage_id' => $stage->id,
            ]);
            $stageImageIds[] = $stageImage->id;
        }
        StageImage::where('stage_id', $stage->id)
            ->whereNotIn('id', $stageImageIds)
            ->delete();
    }
}

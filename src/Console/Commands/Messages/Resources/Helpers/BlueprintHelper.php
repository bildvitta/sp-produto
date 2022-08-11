<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Blueprint;
use BildVitta\SpProduto\Models\RealEstateDevelopment\BlueprintImage;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Accessory;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
use stdClass;

trait BlueprintHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function blueprints(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $blueprintIds = [];
        foreach($message->blueprints as $messageBlueprint) {
            $blueprint = Blueprint::updateOrCreate([
                'uuid' => $messageBlueprint->uuid,
            ], [
                'uuid' => $messageBlueprint->uuid,
                'real_estate_development_id' => $realEstateDevelopment->id,
                'name' => $messageBlueprint->name,
                'description' => $messageBlueprint->description,
            ]);
            $blueprintIds[] = $blueprint->id;
            $this->blueprintImages($blueprint, $messageBlueprint->images);
            $this->blueprintTypologies($blueprint, $messageBlueprint->typologies);
            $this->blueprintAccessories($blueprint, $messageBlueprint->accessories);
        }
        Blueprint::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $blueprintIds)
            ->delete();
    }

    /**
     * @param Blueprint $blueprint
     * @param array $messageBlueprintImages
     * @return void
     */
    private function blueprintImages(Blueprint $blueprint, array $messageBlueprintImages)
    {
        $blueprintImageIds = [];
        foreach($messageBlueprintImages as $messageBlueprintImage) {
            $blueprintImage = BlueprintImage::updateOrCreate([
                'uuid' => $messageBlueprintImage->uuid,
            ], [
                'uuid' => $messageBlueprintImage->uuid,
                'blueprint_id' => $blueprint->id,
                'name' => $messageBlueprintImage->name ?? '',
                'image' => explode("?", $messageBlueprintImage->image)[0],
                'format' => $messageBlueprintImage->format ?? '',
            ]);
            $blueprintImageIds[] = $blueprintImage->id;
        }
        BlueprintImage::where('blueprint_id', $blueprint->id)
            ->whereNotIn('id', $blueprintImageIds)
            ->delete();
    }

    /**
     * @param Blueprint $blueprint
     * @param array $messageBlueprintTypologies
     * @return void
     */
    private function blueprintTypologies(Blueprint $blueprint, array $messageBlueprintTypologies): void
    {
        $typologyUuids = collect($messageBlueprintTypologies)->pluck('uuid')->toArray();
        if ($typologyUuids) {
            $typologies = Typology::whereIn('uuid', $typologyUuids)->get();
            $blueprint->typologies()->sync($typologies);
        }
        if (empty($messageBlueprintTypologies)) {
            $blueprint->typologies()->detach();
        }
    }

    /**
     * @param Blueprint $blueprint
     * @param array $messageBlueprintAccessories
     * @return void
     */
    private function blueprintAccessories(Blueprint $blueprint, array $messageBlueprintAccessories): void
    {
        $accessoryUuids = collect($messageBlueprintAccessories)->pluck('uuid')->toArray();
        if ($accessoryUuids) {
            $accessories = Accessory::whereIn('uuid', $accessoryUuids)->get();
            $blueprint->real_estate_development_accessories()->sync($accessories);
        }
        if (empty($messageBlueprintAccessories)) {
            $blueprint->real_estate_development_accessories()->detach();
        }
    }
}

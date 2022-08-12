<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Media;
use stdClass;

trait MediaHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function medias(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $mediaIds = [];
        foreach($message->medias as $messageMedia) {
            $media = Media::updateOrCreate([
                'uuid' => $messageMedia->uuid,
            ], [
                'uuid' => $messageMedia->uuid,
                'real_estate_development_id' => $realEstateDevelopment->id,
                'name' => $messageMedia->name,
                'description' => $messageMedia->description,
                'media_type' => $messageMedia->media_type,
                'url' => $messageMedia->url,
                'preview' => $messageMedia->preview,
                'format' => $messageMedia->format,
                'active' => $messageMedia->active,
            ]);
            $mediaIds[] = $media->id;
        }
        Media::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $mediaIds)
            ->delete();
    }
}

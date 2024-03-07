<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use BildVitta\SpProduto\Models\RealEstateDevelopment\Document;
use stdClass;

trait DocumentHelper
{
    private function documents(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $documentIds = [];
        foreach ($message->documents as $messageDocument) {
            $document = Document::updateOrCreate([
                'uuid' => $messageDocument->uuid,
            ], [
                'uuid' => $messageDocument->uuid,
                'real_estate_development_id' => $realEstateDevelopment->id,
                'name' => $messageDocument->name,
                'format' => $messageDocument->format,
                'type' => $messageDocument->type,
                'url' => $messageDocument->url,
                'preview' => $messageDocument->preview,
                'description' => $messageDocument->description,
            ]);
            $documentIds[] = $document->id;
        }
        Document::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $documentIds)
            ->delete();
    }
}

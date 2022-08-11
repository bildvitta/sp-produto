<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Mirror;
use BildVitta\SpProduto\Models\RealEstateDevelopment\MirrorGroup;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use stdClass;

trait MirrorHelper
{
    /**
     * @param RealEstateDevelopment $realEstateDevelopment
     * @param stdClass $message
     * @return void
     */
    private function mirrors(RealEstateDevelopment $realEstateDevelopment, stdClass $message): void
    {
        $mirrorIds = [];
        $mirrorSubgroupIds = [];
        foreach ($message->mirrors as $messageMirror) {
            $mirror = Mirror::updateOrCreate([
                'uuid' => $messageMirror->uuid
            ], [
                'uuid' => $messageMirror->uuid,
                'name' => $messageMirror->name,
                'mirror_type' => $messageMirror->mirror_type,
                'real_estate_development_id' => $realEstateDevelopment->id,
            ]);
            $mirrorIds[] = $mirror->id;
            $mirrorSubgroupIds = [];
            foreach ($messageMirror->subgroups as $messageMirrorSubgroup) {
                $mirrorGroup = MirrorGroup::updateOrCreate([
                    'uuid' => $messageMirrorSubgroup->uuid
                ], [
                    'uuid' => $messageMirrorSubgroup->uuid,
                    'name' => $messageMirrorSubgroup->name,
                    'mirror_id' => $mirror->id,
                ]);
                $mirrorSubgroupIds[] = $mirrorGroup->id;
            }
            MirrorGroup::where('mirror_id', $mirror->id)
                ->whereNotIn('id', $mirrorSubgroupIds)
                ->delete();
        }
        Mirror::where('real_estate_development_id', $realEstateDevelopment->id)
            ->whereNotIn('id', $mirrorIds)
            ->delete();
    }
}

<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait SyncRelated
{
    private function syncRelated(
        Builder $query,
        array $model,
        array $foreign,
        string $pivot,
        string $label
    ): void {
        if (is_null($this->worker->payload->total)) {
            $payload = $this->worker->payload;
            $payload->total = $query->count();
            $this->updateWorker(['payload' => $payload]);
            DB::table(prefixTableName($pivot))->delete();
        }

        if ($this->worker->payload->total > 0) {
            $query->limit($this->worker->payload->limit)->offset($this->worker->payload->offset);

            $query->get()->each(function ($item) use ($model, $foreign, $pivot) {
                if (! $model['class']) {
                    $array = [
                        'id' => $item->model_uuid,
                    ];
                    $modelObject = json_decode(json_encode($array), false);
                    $modelField = $model['field'];
                }

                if ($model['class']) {
                    $modelObject = $model['class']::where('uuid', $item->model_uuid);
                    if (in_array(SoftDeletes::class, class_uses($model['class']))) {
                        $modelObject->withTrashed();
                    }
                    $modelObject = $modelObject->first();

                    $modelField = sprintf('%s_id', $model['field']);
                }

                if (! $foreign['class']) {
                    $array = [
                        'id' => $item->foreign_uuid,
                    ];
                    $foreignObject = json_decode(json_encode($array), false);
                    $foreignField = $foreign['field'];
                }

                if ($foreign['class']) {
                    $foreignObject = $foreign['class']::where('uuid', $item->foreign_uuid);
                    if (in_array(SoftDeletes::class, class_uses($foreign['class']))) {
                        $foreignObject->withTrashed();
                    }
                    $foreignObject = $foreignObject->first();

                    $foreignField = sprintf('%s_id', $foreign['field']);
                }

                if ($modelObject && $foreignObject) {
                    DB::table(prefixTableName($pivot))
                        ->insert([
                            $modelField => $modelObject->id,
                            $foreignField => $foreignObject->id,
                        ]);
                }
            });
        }
    }
}

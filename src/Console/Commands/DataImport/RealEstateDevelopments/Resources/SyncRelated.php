<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait SyncRelated
{
    /**
         * @param Builder $query
         * @param array $model
         * @param array $foreign
         * @param string $pivot
         * @param string $label
         * @return void
         */
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
                $modelObject = $model['class']::where('uuid', $item->model_uuid);
                $foreignObject = $foreign['class']::where('uuid', $item->foreign_uuid);

                if (in_array(SoftDeletes::class, class_uses($model['class']))) {
                    $modelObject->withTrashed();
                }
                $modelObject = $modelObject->first();

                if (in_array(SoftDeletes::class, class_uses($foreign['class']))) {
                    $foreignObject->withTrashed();
                }
                $foreignObject = $foreignObject->first();

                if ($modelObject && $foreignObject) {
                    DB::table(prefixTableName($pivot))
                        ->insert([
                            sprintf('%s_id', $model['field']) => $modelObject->id,
                            sprintf('%s_id', $foreign['field']) => $foreignObject->id,
                        ]);
                }
            });
        }
    }
}

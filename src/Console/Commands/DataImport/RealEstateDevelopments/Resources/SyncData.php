<?php

namespace BildVitta\SpProduto\Console\Commands\DataImport\RealEstateDevelopments\Resources;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

trait SyncData
{
    private function syncData(
        Builder $query,
        string $model,
        ?string $label = null,
        array $related = [],
        array $dates = []
    ): void {
        if (is_null($this->worker->payload->total)) {
            $payload = $this->worker->payload;
            $payload->total = $query->count();
            $this->updateWorker(['payload' => $payload]);
        }

        if ($this->worker->payload->total > 0) {
            $query->limit($this->worker->payload->limit)->offset($this->worker->payload->offset);

            $query->get()->each(function ($item) use ($model, $related, $dates) {
                foreach ($related as $name => $object) {
                    $relatedObject = $object::where('uuid', $item->{sprintf('%s_uuid', $name)});
                    if (in_array(SoftDeletes::class, class_uses($object))) {
                        $relatedObject->withTrashed();
                    }
                    $relatedObject = $relatedObject->first();
                    $item->{sprintf('%s_id', $name)} = $relatedObject?->id;
                }

                foreach ($dates as $date) {
                    $item->{$date} = Carbon::parse($item->{$date})->greaterThan('0001-01-01 23:59:59') ? $item->{$date} : null;
                }

                $newObj = $model::where('uuid', $item->uuid);

                if (in_array(SoftDeletes::class, class_uses($model))) {
                    $newObj->withTrashed();
                }

                if (! $newObj = $newObj->first()) {
                    $newObj = new $model;
                }

                $newObj->fill(collect($item)->toArray());

                $newObj->save();
            });
        }
    }
}

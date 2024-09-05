<?php

namespace BildVitta\SpProduto\Events\RealEstateDevelopments;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealEstateDevelopmentUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public ?string $realEstateDevelopmentUuid) {}
}

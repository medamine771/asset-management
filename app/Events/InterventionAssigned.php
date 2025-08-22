<?php

namespace App\Events;

use App\Models\Intervention;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InterventionAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $intervention;

    public function __construct(Intervention $intervention)
    {
        $this->intervention = $intervention;
    }
}
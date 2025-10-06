<?php

namespace App\Events;

use App\Models\Report_instansi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateInstansi implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report;

    public function __construct(Report_instansi $report)
    {
        $this->report = $report;

    }

    public function broadcastOn(): Channel
    {
        return new Channel('instansi_update');
    }

    public function broadcastAs(): string
    {
        return 'instansi.updated';
    }
}

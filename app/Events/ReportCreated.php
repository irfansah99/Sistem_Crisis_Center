<?php

namespace App\Events;

use App\Models\Report;
use Illuminate\Broadcasting\Channel;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportCreated implements ShouldBroadcast , ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;

    }

    public function broadcastOn(): Channel
    {
        return new Channel('reports');
    }

    public function broadcastAs(): string
    {
        return 'report.created';
    }
}

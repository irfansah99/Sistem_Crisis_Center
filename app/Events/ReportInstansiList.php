<?php

namespace App\Events;

use App\Models\Report_instansi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportInstansiList implements ShouldBroadcast , ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reportInstansi;

    public function __construct(Report_instansi $reportInstansi)
    {
        $this->reportInstansi = $reportInstansi;
    }


    public function broadcastOn(): Channel
    {
        return new Channel('report_instansi');
    }


    public function broadcastAs(): string
    {
        return 'report.instansi';
    }

    public function broadcastWith(): array
    {
        return [
            'instansi_id' => $this->reportInstansi->instansi_id,
        ];
    }
    
}

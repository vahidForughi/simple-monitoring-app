<?php

namespace App\Events\Monitor;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MonitorsExpiredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $connection = 'rabbitmq-monitor';

    /**
     * Create a new event instance.
     */
    public function __construct(
        public array $monitors
    )
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        Log::info("MonitorEvent");

        return [
//            new PrivateChannel('channel-name'),
        ];
    }
}

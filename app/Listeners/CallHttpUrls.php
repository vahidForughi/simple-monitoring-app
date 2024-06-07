<?php

namespace App\Listeners;

use App\Events\Monitor\MonitorsExpiredEvent;
use App\Models\Monitor;
use App\Services\Monitor\MonitorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CallHttpUrls implements ShouldQueue
{
    const CUNCURRENT_HTTP_CALL = 5;

    public $tries = 3;

    public $backoff = 1;

    public $queue = 'call-http-urls';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MonitorsExpiredEvent $event): void
    {
        Log::info('CallHttpUrls', $event->monitors);

        // Call http urls chunk by chunk
        foreach (
            array_chunk(
                array: $event->monitors,
                length: self::CUNCURRENT_HTTP_CALL
            ) as $monitors_chunk
        ) {
            $responses = Http::pool(fn (Pool $pool) =>
                array_map(
                    callback: fn ($monitor) =>
                        $pool->withoutVerifying()
                            ->send($monitor->method , $monitor->url, $monitor->body ?? []),
                    array: $monitors_chunk,
                )
            );

            foreach ($responses as $index => $response) {
                if (method_exists($response, 'status')) {
                    resolve(MonitorService::class)->storeMonitorHistory(
                        monitorID: $monitors_chunk[$index]->id,
                        statusCode: $response->status()
                    );
                }
            }
        }

    }
}

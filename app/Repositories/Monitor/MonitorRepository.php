<?php

namespace App\Repositories\Monitor;

use App\DTOs\Monitor\MonitorDTO;
use App\Filters\History\HistoryFilters;
use App\Models\Monitor;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MonitorRepository implements MonitorRepositoryInterface
{
    public function fetchList(array $with = []): Collection
    {
        return Monitor::with($with)->get();
    }

    public function fetchById(string $id, array $with = []): Monitor
    {
        return Monitor::with($with)->find($id);
    }

    public function fetchByIdWithHistories(string $id, HistoryFilters $historyFilters, array $with = []): Monitor|null
    {
        return Monitor::
            with(['histories' => function ($query) use ($historyFilters) {
                return $query->filter($historyFilters)
                    ->get();
            }])
            ->find($id);
    }

    public function store(MonitorDTO $monitorDTO): Monitor
    {
        return Monitor::create([
            "name" => $monitorDTO->name,
            "interval" => $monitorDTO->interval,
            "url" => $monitorDTO->url,
            "method" => $monitorDTO->method,
            "body" => $monitorDTO->body,
            "monitored_at" => $monitorDTO->monitoredAt,
        ]);
    }

    public function updateMonitoredAt(string $id, Carbon $monitoredAt): void
    {
        Monitor::where('id', $id)
            ->update([
                "monitored_at" => $monitoredAt,
            ]);
    }

    public function chunkExpiredMonitorList(int $count, callable $callback): void
    {
        Monitor::whereMonitorExpired()
            ->chunk($count, $callback);
    }

    public function isDuplicate(string $url, string $method, array $body): bool
    {
        // TODO: better check body
        return Monitor::where('url', $url)
            ->where('method', Monitor::METHOD[$method])
            ->where('body', json_encode($body))
            ->exists();
    }
}

<?php

namespace App\Repositories\Monitor;

use App\DTOs\Monitor\MonitorDTO;
use App\Filters\History\HistoryFilters;
use App\Models\Monitor;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface MonitorRepositoryInterface
{
    public function fetchList(array $with = []): Collection;
    public function fetchById(string $id, array $with = []): Monitor;
    public function fetchByIdWithHistories(string $id, HistoryFilters $filters, array $with = []): Monitor|null;
    public function store(MonitorDTO $monitorDTO): Monitor;
    public function updateMonitoredAt(string $id, Carbon $monitoredAt): void;
    public function chunkExpiredMonitorList(int $count, callable $callback): void;
    public function isDuplicate(string $url, string $method, array $body): bool;
}

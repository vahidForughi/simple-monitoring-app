<?php

namespace App\Services\Monitor;

use App\DTOs\Monitor\MonitorDTO;
use App\Events\Monitor\MonitorsExpiredEvent;
use App\Filters\History\HistoryFilters;
use App\Models\Monitor;
use App\Repositories\Monitor\MonitorRepositoryInterface;
use App\Services\History\HistoryService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MonitorService
{
    const CUNCURRENT_FETCH_MONITOR_COUNT = 100;

    const CUNCURRENT_MONITORS_IN_EVERY_EVENT = 15;


    public function __construct(
        private MonitorRepositoryInterface $monitorRepository,
    ) {}

    public function fetchList(): Collection
    {
        return $this->monitorRepository->fetchList();
    }

    public function fetch(
        string $id,
        HistoryFilters $historyFilters,
    ): Monitor
    {
        if (empty(
                $monitor = $this->monitorRepository->fetchByIdWithHistories(
                    id: $id,
                    historyFilters: $historyFilters
                )
            )
        ) {
            throw new NotFoundHttpException('monitor not found');
        }

        return $monitor;
    }

    public function store(
        string $name,
        string $interval,
        string $url,
        string|null $method = null,
        array|null $body = null,
    ): Monitor
    {
        if ($this->monitorRepository->isDuplicate($url, $method, $body)) {
            throw new NotFoundHttpException('url duplicated');
        }

        $monitor = $this->monitorRepository->store(
            new MonitorDTO(
                name: $name,
                interval: $interval,
                url: $url,
                method: Monitor::METHOD[$method ?? 'GET'],
                body: $body,
                monitoredAt: null,
            )
        );

        return $monitor;
    }

    public function run(): void
    {
        Log::info("MonitorService run");

        $this->monitorRepository->chunkExpiredMonitorList(
            count: self::CUNCURRENT_FETCH_MONITOR_COUNT,
            callback: function ($monitors) {
                if (count($monitors->all()) > 0) {
                    foreach (
                        array_chunk($monitors->all(), self::CUNCURRENT_MONITORS_IN_EVERY_EVENT)
                        as $monitors_chunk
                    ) {
                        MonitorsExpiredEvent::dispatch($monitors_chunk);
                    }
                }
            }
        );
    }

    public function storeMonitorHistory(
        string $monitorID,
        int $statusCode,
    ): void {
        // TODO: check monitor exists

        DB::beginTransaction();

        try {

            $this->monitorRepository->updateMonitoredAt(
                id: $monitorID,
                monitoredAt: now(),
            );

            resolve(HistoryService::class)->store(
                monitorID: $monitorID,
                statusCode: $statusCode,
            );

        }
        catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage);
        }
        finally {
            DB::commit();
        }

    }
}

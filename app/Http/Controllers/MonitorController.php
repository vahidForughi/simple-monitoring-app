<?php

namespace App\Http\Controllers;

use App\Filters\History\HistoryFilters;
use App\Http\Requests\Monitor\IndexRequest;
use App\Http\Requests\Monitor\ShowRequest;
use App\Http\Requests\Monitor\StoreRequest;
use App\Http\Resources\Monitor\MonitorResource;
use App\Services\Monitor\MonitorService;

class MonitorController extends Controller
{

    public function index(IndexRequest $indexRequest)
    {
        $indexRequest->validated();

        return response()->jsonSuccess(
            data: MonitorResource::collection(
                resolve(MonitorService::class)->fetchList()
            )->toArray(request: $indexRequest),
        );
    }

    public function store(StoreRequest $storeRequest)
    {
        $validated_data = $storeRequest->validated();

        return response()->jsonSuccess(
            data: new MonitorResource(resolve(MonitorService::class)->store(
                name: $validated_data['name'],
                interval: $validated_data['interval'],
                url: $validated_data['url'],
                method: $validated_data['method'] ?? null,
                body: $validated_data['body'] ?? null,
            )),
        );
    }

    public function show(ShowRequest $showRequest)
    {
        $validated_data = $showRequest->validated();

        return response()->jsonSuccess(
            data: new MonitorResource(resolve(MonitorService::class)->fetch(
                id: $validated_data['monitor_id'],
                historyFilters: new HistoryFilters($validated_data)),
            ),
        );
    }

}

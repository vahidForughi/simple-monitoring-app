<?php

namespace App\Repositories\History;

use App\DTOs\History\HistoryDTO;
use App\Models\History;

class HistoryRepository implements HistoryRepositoryInterface
{
    public function store(HistoryDTO $historyDTO): History
    {
        return History::create([
            "monitor_id" => $historyDTO->monitorID,
            "status_code" => $historyDTO->statusCode,
        ]);
    }
}

<?php

namespace App\Services\History;

use App\DTOs\History\HistoryDTO;
use App\Models\History;
use App\Repositories\History\HistoryRepositoryInterface;

class HistoryService
{
    public function __construct(
        private HistoryRepositoryInterface $historyRepository,
    ) {}

   public function store(
        string $monitorID,
        int $statusCode,
    ): History
    {
        $history = $this->historyRepository->store(
            new HistoryDTO(
                monitorID: $monitorID,
                statusCode: $statusCode,
            )
        );

        return $history;
    }
}

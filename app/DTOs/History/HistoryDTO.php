<?php

namespace App\DTOs\History;

readonly class HistoryDTO
{
    public function __construct(
        public string $monitorID,
        public int $statusCode,
    ) {}
}

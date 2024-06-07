<?php

namespace App\Repositories\History;

use App\DTOs\History\HistoryDTO;
use App\Models\History;

interface HistoryRepositoryInterface
{
    public function store(HistoryDTO $historyDTO): History;
}

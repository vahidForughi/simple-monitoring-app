<?php

namespace App\DTOs\Monitor;

use Carbon\Carbon;

readonly class MonitorDTO
{
    public function __construct(
        public string $name,
        public int $interval,
        public string $url,
        public string|null $method = null,
        public array|null $body = null,
        public Carbon|null $monitoredAt = null,
    ) {}
}

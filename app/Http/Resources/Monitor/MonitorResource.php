<?php

namespace App\Http\Resources\Monitor;

use App\Http\Resources\History\HistoryResource;
use App\Http\Resources\History\PaginatedHistoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonitorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'interval' => $this->interval,
            'url' => $this->url,
            'method' => $this->method,
            'body' => $this->body,
            'monitored_at' => $this->monitored_at,
            'histories' => $this->relationLoaded('histories')
                ? HistoryResource::collection($this->histories)
                : null,
        ];
    }
}

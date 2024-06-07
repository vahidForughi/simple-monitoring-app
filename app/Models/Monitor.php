<?php

namespace App\Models;

use App\DTOs\Monitor\MonitorDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitor extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    const METHOD = [
        'GET' => 1,
        'POST' => 2,
        'PUT' => 3,
        'PATCH' => 4,
        'DELETE' => 5,
    ];

    protected $fillable = [
        'name',
        'interval',
        'url',
        'method',
        'body',
        'monitored_at',
    ];

    protected $casts = [
        'body' => 'json',
        'monitored_at' => 'datetime'
    ];

    public function toDTO(): MonitorDTO
    {
        return new MonitorDTO(
            name: $this->name,
            interval: $this->interval,
            url: $this->url,
            method: $this->method,
            body: $this->body,
            monitoredAt: $this->monitored_at,
        );
    }

    public function histories(): HasMany
    {
        return $this->hasMany(
            related: History::class,
            foreignKey: 'monitor_id',
            localKey: 'id',
        );
    }

    protected function method(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => array_search($value, self::METHOD),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value),
        );
    }

    public function scopeWhereMonitorExpired($query)
    {
        return $query
            ->where(fn ($q) =>
                $q
                    ->whereNull('monitored_at')
                    ->orWhereRaw('DATE_ADD(`monitored_at`, INTERVAL `interval` MINUTE) <= NOW()')
            );
    }
}

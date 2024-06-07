<?php
namespace App\Filters\History;

use App\Filters\QueryFilters;
use Carbon\Carbon;

class HistoryFilters extends QueryFilters
{
    protected array $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
        parent::__construct($filters);
    }

    public function statusCode($term = null) {
        return $term ? $this->builder->where('status_code', '=', $term) : $this->builder;
    }

    public function startDate($term = null) {
        return $term
            ? $this->builder
                ->where(fn ($query) =>
                    $query->whereDate('created_at', '=', Carbon::create($term)->toDateString())
                        ->whereTime('created_at', '>=', Carbon::create($term)->toTimeString())
                        ->orWhere(fn ($q) =>
                            $q->whereDate('created_at', '>', Carbon::create($term)->toDateString())
                        )
                )
            : $this->builder;
    }

    public function endDate($term = null) {
        return $term
            ? $this->builder
                ->where(fn ($query) =>
                    $query->whereDate('created_at', '=', Carbon::create($term)->toDateString())
                        ->whereTime('created_at', '<=', Carbon::create($term)->toTimeString())
                        ->orWhere(fn ($q) =>
                            $q->whereDate('created_at', '<', Carbon::create($term)->toDateString())
                        )
                )
            : $this->builder;
    }
}

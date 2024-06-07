<?php

namespace App\Traits;

use App\Filters\QueryFilters;

trait HasFilters
{
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}

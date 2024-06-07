<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QueryFilters
{
    protected array $filters;

    protected $builder;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            $method_name = Str::camel($name);

            if ( ! method_exists($this, $method_name)) {
                continue;
            }

            if (strlen($value)) {
                $this->$method_name($value);
            } else {
                $this->$method_name();
            }
        }

        return $this->builder;
    }

    public function filters(): array
    {
        return $this->filters;
    }
}

<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterTitleOrDescription implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function ($q) use ($value) {
            $value = strtolower(trim($value));
            $q->where('title', 'like', "%{$value}%")
                ->orWhere('description', 'like', "%{$value}%");
        });
    }
}

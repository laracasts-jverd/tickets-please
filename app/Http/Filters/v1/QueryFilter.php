<?php

namespace App\Http\Filters\v1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected Builder $builder;

    protected Request $request;

    protected array $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter(array $arr): Builder
    {
        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    /**
     * Apply the filters to the builder.
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    /**
     * Sort the results.
     */
    protected function sort($value)
    {
        $sortAttributes = explode(',', $value);

        // Sort the results by the given attributes.
        foreach ($sortAttributes as $attribute) {
            $direction = 'asc';

            // Check if the attribute has a direction.
            if (strpos($attribute, '-') === 0) {
                $direction = 'desc';
                $attribute = substr($attribute, 1);
            }

            // Skip the attribute if it's not sortable.
            if (! in_array($attribute, $this->sortable) && ! array_key_exists($attribute, $this->sortable)) {
                continue;
            }
            $column = $this->sortable[$attribute] ?? $attribute;

            $this->builder->orderBy($column, $direction);
        }
    }
}

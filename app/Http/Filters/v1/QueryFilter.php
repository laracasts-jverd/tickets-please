<?php

namespace App\Http\Filters\v1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected Builder $builder;

    protected Request $request;

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
}

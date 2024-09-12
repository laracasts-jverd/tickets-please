<?php

namespace App\Http\Filters\v1;

class AuthorFilter extends QueryFilter
{
    /**
     * The attributes that are sortable.
     */
    protected $sortable = [
        'name',
        'email',
        'createdAt' => 'created_at',
    ];

    /**
     * Filter by author creation date.
     */
    public function createdAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    /**
     * Include or not related models to the payload.
     */
    public function include($value)
    {
        return $this->builder->with($value);
    }

    /**
     * Filter by author ids.
     */
    public function id($values)
    {
        return $this->builder->whereIn('id', explode(',', $values));
    }

    /**
     * Filter by author email.
     */
    public function email($value)
    {
        return $this->builder->where('email', 'like', "%$value%");
    }

    /**
     * Filter by author name.
     */
    public function name($value)
    {
        return $this->builder->where('name', 'like', "%$value%");
    }
}

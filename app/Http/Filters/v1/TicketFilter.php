<?php

namespace App\Http\Filters\v1;

class TicketFilter extends QueryFilter
{
    /**
     * Filter by ticket creation date.
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
     * Filter by ticket status.
     */
    public function status($values)
    {
        return $this->builder->whereIn('status', explode(',', $values));
    }

    /**
     * Filter by ticket title.
     */
    public function title($value)
    {
        return $this->builder->where('title', 'like', "%$value%");
    }
}

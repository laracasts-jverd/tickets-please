<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Check if the request includes a relationship.
     */
    public function include(string $relationship): bool
    {
        $param = request()->get('include');
        if (! isset($param)) {
            return false;
        }
        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }
}

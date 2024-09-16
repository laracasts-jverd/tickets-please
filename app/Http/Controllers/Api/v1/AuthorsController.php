<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\v1\AuthorFilter;
use App\Http\Requests\Api\v1\User\StoreUserRequest;
use App\Http\Requests\Api\v1\User\UpdateUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class AuthorsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filters)
    {
        return UserResource::collection(User::filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $author)
    {
        if ($this->include('tickets')) {
            $author->load('tickets');
        }

        return UserResource::make($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $author)
    {
        //
    }
}

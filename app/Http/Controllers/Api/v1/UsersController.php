<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\StoreUserRequest;
use App\Http\Requests\Api\v1\UpdateUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class UsersController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate();

        if ($this->include('tickets')) {
            $users->load('tickets');
        }

        return UserResource::collection($users);
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
    public function show(User $user)
    {
        if ($this->include('tickets')) {
            $user->load('tickets');
        }

        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

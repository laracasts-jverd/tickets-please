<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\v1\AuthorFilter;
use App\Http\Requests\Api\v1\Ticket\ReplaceUserRequest;
use App\Http\Requests\Api\v1\User\StoreUserRequest;
use App\Http\Requests\Api\v1\User\UpdateUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filters)
    {
        return UserResource::collection(
            User::filter($filters)->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $this->authorize('store', User::class);

            return new UserResource(User::create($request->mappedAttributes()));
        } catch (AuthorizationException $e) {
            return $this->error('This action is unauthorized.', 403);
        }

        return new UserResource(User::create($request->mappedAttributes()));
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
    public function update(UpdateUserRequest $request, User $userId)
    {
        // PATCH
        try {
            $user = User::findOrFail($userId);
            $this->authorize('update', $user);
            $user->update($request->mappedAttributes());

        } catch (ModelNotFoundException $e) {
            return $this->error('User not found', 404);
        } catch (AuthorizationException $e) {
            return $this->error('This action is unauthorized.', 403);
        }

        return new UserResource($user);
    }

    public function replace(ReplaceUserRequest $request, $userId)
    {
        // PUT
        try {
            $user = User::findOrFail($userId);
            $this->authorize('replace', $user);
            $user->update($request->mappedAttributes());

        } catch (ModelNotFoundException $e) {
            return $this->error('User not found', 404);
        } catch (AuthorizationException $e) {
            return $this->error('This action is unauthorized.', 403);
        }

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);
        $user->delete();

        return $this->ok('User deleted successfully', [
            'message' => 'The user was deleted successfully.',
        ]);
    }
}

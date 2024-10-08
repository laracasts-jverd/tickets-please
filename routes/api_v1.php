<?php

use App\Http\Controllers\Api\v1\AuthorsController;
use App\Http\Controllers\Api\v1\AuthorTicketsController;
use App\Http\Controllers\Api\v1\TicketsController;
use App\Http\Controllers\Api\v1\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('tickets', TicketsController::class)->except(['update']);
    Route::put('tickets/{ticket}', [TicketsController::class, 'replace']);
    Route::patch('tickets/{ticket}', [TicketsController::class, 'update']);

    Route::apiResource('users', UsersController::class)->except(['update']);
    Route::put('users/{user}', [UsersController::class, 'replace']);
    Route::patch('users/{user}', [UsersController::class, 'update']);

    Route::apiResource('authors', AuthorsController::class)->except(['store', 'update', 'delete']);
    Route::apiResource('authors.tickets', AuthorTicketsController::class)->except(['update']);
    Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'replace']);
    Route::patch('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'update']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

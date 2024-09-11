<?php

use App\Http\Controllers\Api\v1\TicketsController;
use App\Http\Controllers\Api\v1\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->apiResource('tickets', TicketsController::class);
Route::middleware('auth:sanctum')->apiResource('users', UsersController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

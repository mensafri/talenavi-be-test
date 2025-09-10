<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\ChartController;

Route::post('/todos', [TodoController::class, 'store']);
Route::get('/todos/report', [TodoController::class, 'generateReport']);
Route::get('/chart', [ChartController::class, 'summary']);

// Default route provided by Laravel
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout']);

Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/tasks', [TaskController::class, 'load']);
Route::middleware('auth:sanctum')->post('/tasks', [TaskController::class, 'store']);
Route::middleware('auth:sanctum')->put('/tasks/{id}', [TaskController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/tasks/{id}', [TaskController::class, 'delete']);

Route::fallback(function () {
    return response()->json([
        'error' => 'Rota não encontrada',
        'message' => 'A rota que você tentou acessar não existe.'
    ], 404);
});

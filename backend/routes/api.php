<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;



Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->get('/user', function(Request $request){
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/tasks', [TaskController::class, 'load'])->name('load');
Route::middleware('auth:sanctum')->post('/tasks', [TaskController::class, 'store'])->name('store');
Route::middleware('auth:sanctum')->put('/tasks/{id}', [TaskController::class, 'update'])->name('update');
Route::middleware('auth:sanctum')->delete('/tasks/{id}', [TaskController::class, 'delete'])->name('delete');

Route::fallback(function () {
    return response()->json([
        'error' => 'Rota não encontrada',
        'message' => 'A rota que você tentou acessar não existe.'
    ], 404);
});

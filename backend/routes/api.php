<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::middleware('auth:sanctum')->post('/tasks', [TaskController::class, 'store']);


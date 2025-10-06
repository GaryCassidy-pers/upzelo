<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TODO: Implement your API routes here
// Example structure:
// Route::apiResource('projects', ProjectController::class);
// Route::apiResource('tasks', TaskController::class);

Route::get('/api/projects', [App\Http\Controllers\ProjectController::class, 'index']);
Route::post('/api/projects', [App\Http\Controllers\ProjectController::class, 'store']);
Route::get('/api/projects/{id}', [App\Http\Controllers\ProjectController::class, 'show']);
Route::get('/api/tasks', [App\Http\Controllers\TaskController::class, 'index']);
Route::post('/api/tasks', [App\Http\Controllers\TaskController::class, 'store']);
Route::put('/api/tasks/{id}', [App\Http\Controllers\TaskController::class, 'update']);

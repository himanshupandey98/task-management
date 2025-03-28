<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

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

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index'); // Get all tasks
    Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store'); // Create a task
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show'); // Get a single task
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update'); // Update a task
    Route::patch('tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.mark-as-completed'); // mark task as completed
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy'); // Delete a task
});

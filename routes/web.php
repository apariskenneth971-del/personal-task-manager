<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Redirect the root URL straight to the task list.
Route::redirect('/', '/tasks');

// Full CRUD for tasks: index, create, store, edit, update, destroy.
Route::resource('tasks', TaskController::class);

// Extra route just for the "Update Status" (Pending / Completed) feature.
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
    Route::patch('tasks/updateOrder', [\App\Http\Controllers\TaskController::class, 'updateOrder'])->name('tasks.updateOrder');
    Route::patch('tasks/updateFinished/{task}', [\App\Http\Controllers\TaskController::class, 'updateFinished']);
    Route::patch('taskorder/update', [\App\Http\Controllers\TaskOrderController::class, 'update'])->name('taskorder.update');
});

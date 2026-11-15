<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

Route::prefix('tasks')->name('tasks.')->group(function () {
    Route::get('create', [TaskController::class, 'create'])->name('create');
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::get('{id}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::put('{id}', [TaskController::class, 'update'])->name('update');
    Route::patch('{id}/status', [TaskController::class, 'changeStatus'])->name('status');
    Route::delete('{id}', [TaskController::class, 'destroy'])->name('destroy');
});

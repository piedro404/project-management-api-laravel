<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\v1\{
    ProjectController,
    TaskController,
};

Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/{id}', [ProjectController::class, 'show'])->name('project.show');
    Route::post('/', [ProjectController::class, 'store'])->name('project.store');
    Route::put('/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');

    Route::prefix('{project_id}/tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('task.index');
        Route::get('/{id}', [TaskController::class, 'show'])->name('task.show');
        Route::post('/', [TaskController::class, 'store'])->name('task.store');
        Route::put('/{id}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
        
    });
});
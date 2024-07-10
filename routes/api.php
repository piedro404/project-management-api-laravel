<?php

use App\Http\Controllers\v1\{
    AuthController,
    ProjectController,
    TaskController,
};
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

Route::prefix("/")->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');

        Route::prefix('projects')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('project.index');
            Route::get('/{id}', [ProjectController::class, 'show'])->name('project.show');
            Route::post('/', [ProjectController::class, 'store'])->name('project.store');
            Route::put('/{id}', [ProjectController::class, 'update'])->name('project.update');
            Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');

            Route::prefix('{project_id}/tasks')->group(function () {
                Route::get('/', [TaskController::class, 'index'])->name('task.index');
            });
        });
    });
});

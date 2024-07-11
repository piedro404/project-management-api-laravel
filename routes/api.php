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
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
    
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::put('profile/edit', [AuthController::class, 'edit_profile'])->name('edit_profile');
        Route::put('password/reset', [AuthController::class, 'reset_password'])->name('reset_password');

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
    });
});

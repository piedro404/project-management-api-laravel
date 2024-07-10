<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\ProjectController;
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

Route::prefix("/")->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');

        Route::prefix('projects')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('project.index');

            Route::prefix('{project_id}/tasks')->group(function () {
                
            });
        });
    });
});

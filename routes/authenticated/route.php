<?php

use App\Http\Controllers\v1\{
    AuthController,
};
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me'])->name('me');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::put('profile/edit', [AuthController::class, 'edit_profile'])->name('edit_profile');
    Route::put('password/reset', [AuthController::class, 'reset_password'])->name('reset_password');
    Route::get('tasks', [AuthController::class, 'tasks_description'])->name('tasks_description');
});

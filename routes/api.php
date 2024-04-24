<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('url')->group(function () {
    Route::get('/', [App\Http\Controllers\IndexController::class, 'home']);
    Route::post('/', [App\Http\Controllers\Url\CreateUrlController::class, 'create']);
    Route::patch('/{id}', [App\Http\Controllers\Url\UpdateUrlController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Url\DeleteUrlController::class, 'delete']);
});

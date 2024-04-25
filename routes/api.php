<?php

use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->prefix('url')->name('url.')->group(function () {
        Route::get('/', [App\Http\Controllers\IndexController::class, 'home'])->name('home');
        Route::post('/', [App\Http\Controllers\Url\CreateUrlController::class, 'create'])->name('create');
        Route::patch('/{id}', [App\Http\Controllers\Url\UpdateUrlController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Url\DeleteUrlController::class, 'delete'])->name('delete');
    });
});

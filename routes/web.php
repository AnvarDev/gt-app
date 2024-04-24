<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\IndexController::class, 'home'])->middleware('auth')->name('home');

Auth::routes([
    'reset' => false,
]);

Route::middleware('auth')->prefix('url')->name('url.')->group(function () {
    Route::post('/', [App\Http\Controllers\Url\CreateUrlController::class, 'create'])->name('create');
    Route::get('/{id?}', [App\Http\Controllers\IndexController::class, 'form'])->name('form');
    Route::post('/{id}', [App\Http\Controllers\Url\UpdateUrlController::class, 'update'])->name('update');
    Route::post('/{id}', [App\Http\Controllers\Url\DeleteUrlController::class, 'delete'])->name('delete');
});

Route::get('/{hash_id}', [App\Http\Controllers\Url\RedirectUrlController::class, 'redirect'])->name('redirect');

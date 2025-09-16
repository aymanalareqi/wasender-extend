<?php

use Alareqi\WasenderExtend\Http\Controllers\User\AppsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'user', 'saas', 'web']], function () {
    Route::get('apps/', [AppsController::class, 'index'])->name('apps.index');
    Route::post('apps/', [AppsController::class, 'store'])->name('apps.store');
});

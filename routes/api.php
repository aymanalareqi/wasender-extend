<?php

use Alareqi\WasenderExtend\Http\Controllers\Api\MiscController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['throttle:api']],
    function () {
        Route::middleware('api')
            ->prefix('api')
            ->group(
                function () {
                    Route::post('/misc/on-whatsapp', [MiscController::class, 'onWhatsapp']);
                    Route::post('/qr', [MiscController::class, 'getQr']);
                    Route::post('/check-session', [MiscController::class, 'checkSession']);
                    Route::post('/logout', [MiscController::class, 'logout']);
                }
            );
    }
);

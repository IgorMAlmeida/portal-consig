<?php

use App\Http\Controllers\CscController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('robot')->group(function () {
    Route::post('csc', [CscController::class, 'Consult']);
});

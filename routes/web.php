<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::prefix('request')->group(function () {
    Route::get('/', fn () => view('request'));
    Route::post('/apply', [AuthController::class, 'request']);
});

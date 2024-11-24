<?php

use App\Http\Controllers\Api\RajaOngkirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/province', [RajaOngkirController::class, 'getProvince']);
Route::get('/city/{provinceId}', [RajaOngkirController::class, 'getCity']);
Route::post('/cost', [RajaOngkirController::class, 'getOngkir']);
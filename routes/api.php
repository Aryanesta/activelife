<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Api\RajaOngkirController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\DashboardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/province', [RajaOngkirController::class, 'getProvince']);
Route::get('/city/{provinceId}', [RajaOngkirController::class, 'getCity']);
Route::post('/cost', [RajaOngkirController::class, 'getOngkir']);

Route::post('/midtrans-callback', [TransactionController::class, 'paymentUpdate']);

Route::put('/admin/transaction/confirm', [AdminTransactionController::class, 'confirm_transaction']);
Route::put('/admin/transaction/reject', [AdminTransactionController::class, 'reject_transaction']);
Route::put('/admin/transaction/update-status', [AdminTransactionController::class, 'update_status']);

// Income Chart
Route::get('/admin/income', [DashboardController::class, 'income']);
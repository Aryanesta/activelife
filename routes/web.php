<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserCartController;
use App\Http\Controllers\AdminCartController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductControllerView;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TransactionController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register');

// OTENTIKASIIIII
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Product View
Route::get('/product', [ProductControllerView::class, 'index'])->name('product');

Auth::routes(['verify' => true]);

// Cart View
// Route::get('/cart',  [AdminCartController::class, 'index'])->name('cart')->middleware('auth');

// User Cart
Route::resource('user-cart', UserCartController::class)->names([
    'index' => 'cart.index',
    'create' => 'cart.create',
    'store' => 'cart.store',
    'show' => 'cart.show',
    'edit' => 'cart.edit',
    'update' => 'cart.update',
    'destroy' => 'cart.destroy'
])->middleware('auth');

// Midtrans
Route::get('/payment', [TransactionController::class, 'snapToken'])->name('snapToken');
Route::post('/payment/finish', [TransactionController::class, 'paymentFinish'])->name('finishPayment');

// ADMIN
Route::get('/admin/dashboard', function () {
    return view('/admin/dashboard', [
        'title' => 'Dashboard'
    ]);
})->name('dashboard');

// Product
Route::resource('/admin/product', ProductController::class)->names([
    'index' => 'product.index',
    'create' => 'product.create',
    'store' => 'product.store',
    'show' => 'product.show',
    'edit' => 'product.edit',
    'update' => 'product.update',
    'destroy' => 'product.destroy'
])->middleware('auth');

// Category
Route::resource('/admin/category', ProductCategoryController::class)->names([
    'index' => 'category.index',
    'create' => 'category.create',
    'store' => 'category.store',
    'show' => 'category.show',
    'edit' => 'category.edit',
    'update' => 'category.update',
    'destroy' => 'category.destroy'
])->middleware('auth');

// Transaction
Route::resource('/admin/transaction', AdminTransactionController::class)->names([
    'index' => 'transaction.index',
    'create' => 'transaction.create',
    'store' => 'transaction.store',
    'show' => 'transaction.show',
    'edit' => 'transaction.edit',
    'update' => 'transaction.update',
    'destroy' => 'transaction.destroy'
])->middleware('auth');



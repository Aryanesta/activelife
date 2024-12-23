<?php

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserCartController;
use App\Http\Controllers\AdminCartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductControllerView;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryControllerView;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Symfony\Component\HttpKernel\Profiler\Profile;

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

// Search Bar Product
Route::post('/product', [ProductControllerView::class, 'getProductByName'])->name('searchProducts')->middleware('auth');

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

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('updateProfile')->middleware('auth');

// Transaction History
Route::get('/transaction-history', [TransactionController::class, 'index'])->name('transaction-history')->middleware('auth');
Route::put('/transaction-history/{transaction}', [TransactionController::class, 'paymentUpdate'])->name('updateTransaction')->middleware('auth');

// Category
Route::get('/product-category/{category}', [ProductCategoryControllerView::class, 'index'])->name('category');

// Invoice
Route::get('/invoice/{invoice:order_id}', [InvoiceController::class, 'index'])->name('invoice')->middleware('auth');

// Contact
Route::get('/contact', [ProfileController::class, 'contact'])->name('contact');







// ADMIN

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role.admin');

// Product
Route::resource('/admin/product', ProductController::class)->names([
    'index' => 'product.index',
    'create' => 'product.create',
    'store' => 'product.store',
    'show' => 'product.show',
    'edit' => 'product.edit',
    'update' => 'product.update',
    'destroy' => 'product.destroy'
])->middleware('role.admin');

Route::get('/admin/products', [ProductController::class, 'index'])->name('product')->middleware('role.admin');
Route::post('/admin/products', [ProductController::class, 'getProductByName'])->name('searchProduct')->middleware('role.admin');

// Category
Route::resource('/admin/category', ProductCategoryController::class)->names([
    'index' => 'category.index',
    'create' => 'category.create',
    'store' => 'category.store',
    'show' => 'category.show',
    'edit' => 'category.edit',
    'update' => 'category.update',
    'destroy' => 'category.destroy'
])->middleware('role.admin');

Route::get('/admin/searchCategory', [ProductCategoryController::class, 'index'])->name('category')->middleware('role.admin');
Route::post('/admin/searchCategory', [ProductCategoryController::class, 'getCategoryByName'])->name('searchCategory')->middleware('role.admin');

// Transaction
Route::resource('/admin/transaction', AdminTransactionController::class)->names([
    'index' => 'transaction.index',
    'create' => 'transaction.create',
    'store' => 'transaction.store',
    'show' => 'transaction.show',
    'edit' => 'transaction.edit',
    'update' => 'transaction.update',
    'destroy' => 'transaction.destroy'
])->middleware('role.admin');

Route::get('/admin/searchTransaction', [AdminTransactionController::class, 'index'])->name('transaction')->middleware('role.admin');
Route::post('/admin/searchTransaction', [AdminTransactionController::class, 'getTransactionByOrderId'])->name('searchTransaction')->middleware('role.admin');

// Customer
Route::get('/admin/customer', [CustomerController::class, 'index'])->name('customer')->middleware('role.admin');
Route::put('/admin/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update')->middleware('role.admin');
Route::post('/admin/customer', [CustomerController::class, 'getCustomerByName'])->name('searchCustomer')->middleware('role.admin');

// Report
Route::get('/admin/report', [ReportController::class, 'index'])->name('report')->middleware('role.admin');
Route::post('/admin/report', [ReportController::class, 'filter'])->name('report.filter')->middleware('role.admin');
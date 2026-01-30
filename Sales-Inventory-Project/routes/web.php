<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Symfony\Component\HttpKernel\DependencyInjection\RegisterControllerArgumentLocatorsPass;

// Pages
Route::get('/', [HomeController::class, 'homePage']);
Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->name('dashboard');
Route::get('/categoryPage', [CategoryController::class, 'categoryPage'])->name('categoryPage');
Route::get('/customerPage', [CustomerController::class, 'customerPage'])->name('customerPage');
Route::get('/productPage', [ProductController::class, 'productPage'])->name('productPage');
Route::get('/salePage', [SaleController::class, 'salePage'])->name('salePage');
Route::get('/invoicePage', [InvoiceController::class, 'invoicePage'])->name('invoicePage');
Route::get('/reportPage', [ReportController::class, 'reportPage'])->name('reportPage');
Route::get('/userRegistration', [UserController::class, 'registrationPage']);
Route::get('/userLogin', [UserController::class, 'loginPage']);
Route::get('/resetpasswordPage', [UserController::class, 'resetpasswordPage']);
Route::get('/sendOtp', [UserController::class, 'sendotpPage']);
Route::get('/verifyOtp', [UserController::class, 'verifyotpPage']);
Route::get('/userProfile', [UserController::class, 'profilePage']);

//Login Functionality
Route::post('/user-registration', [UserController::class, 'userRegistration']);
Route::post('/user-login', [UserController::class, 'userLogin']);
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/send-otp', [UserController::class, 'sendOTP']);
Route::post('/verify-otp', [UserController::class, 'verifyOTP']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware('token.verify');
Route::get('/user-profile', [UserController::class, 'userProfile'])->middleware('token.verify');
Route::post('user-profile-update', [UserController::class, 'updateUserProfile'])->middleware('token.verify');

// Category
Route::get('/category-list', [CategoryController::class, 'categoryList'])->middleware('token.verify');
Route::post('/category-create', [CategoryController::class, 'createCategory'])->middleware('token.verify');
Route::post('/category-delete', [CategoryController::class, 'categoryDelete'])->middleware('token.verify');
Route::post('/categoryById', [CategoryController::class, 'categoryById'])->middleware('token.verify');
Route::post('/category-update', [CategoryController::class, 'categoryUpdate'])->middleware('token.verify');

// Customer API
Route::post('/customer-create', [CustomerController::class, 'customerCreate'])->middleware('token.verify');
Route::get('/customer-list', [CustomerController::class, 'customerList'])->middleware('token.verify');
Route::delete('/customer-delete', [CustomerController::class, 'customerDelete'])->middleware('token.verify');
Route::get('/customer-by-id', [CustomerController::class, 'customerById'])->middleware('token.verify');
Route::post('/customer-update', [CustomerController::class, 'customerUpdate'])->middleware('token.verify');

// product
Route::post('/product-create', [ProductController::class, 'createProduct'])->middleware('token.verify');
Route::get('/product-list', [ProductController::class, 'productList'])->middleware('token.verify');
Route::post('/product-by-id', [ProductController::class, 'productById'])->middleware('token.verify');
Route::post('/product-delete', [ProductController::class, 'productDelete'])->middleware('token.verify');
Route::post('/product-update', [ProductController::class, 'productUpdate'])->middleware('token.verify');

// invoice
Route::post('/invoice-create', [InvoiceController::class, 'invoiceCreate'])->middleware('token.verify');

// Dashboard Summary
Route::get('/summary', [DashboardController::class, 'summary'])->middleware('token.verify');

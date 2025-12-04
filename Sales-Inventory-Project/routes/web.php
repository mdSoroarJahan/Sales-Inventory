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

Route::get('/', [HomeController::class, 'homePage']);
Route::get('/dashboard', [DashboardController::class, 'dashboardPage']);
Route::get('/categoryPage', [CategoryController::class, 'categoryPage']);
Route::get('/customerPage', [CustomerController::class, 'customerPage']);
Route::get('/productPage', [ProductController::class, 'productPage']);
Route::get('/salePage', [SaleController::class, 'salePage']);
Route::get('/invoicePage', [InvoiceController::class, 'invoicePage']);
Route::get('/reportPage', [ReportController::class, 'reportPage']);
Route::get('/userRegistration', [UserController::class, 'registrationPage']);
Route::get('/userLogin', [UserController::class, 'loginPage']);
Route::get('/resetpasswordPage', [UserController::class, 'resetpasswordPage']);
Route::get('/sendOtp', [UserController::class, 'sendotpPage']);
Route::get('/verifyOtp', [UserController::class, 'verifyotpPage']);
Route::get('/userProfile', [UserController::class, 'profilePage']);

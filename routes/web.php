<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', fn () => view('dashboard'));
    Route::get('/dashboard', fn () => view('dashboard'));

    Route::get('/profile', App\Http\Controllers\ProfileController::class)->name('profile');

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleAndPermissionController::class);
});

Route::resource('companies', App\Http\Controllers\CompanyController::class)->middleware('auth');

Route::resource('banks', App\Http\Controllers\BankController::class)->middleware('auth');
Route::resource('bank-accounts', App\Http\Controllers\BankAccountController::class)->middleware('auth');
Route::resource('wa-gateways', App\Http\Controllers\WaGatewayController::class)->middleware('auth');

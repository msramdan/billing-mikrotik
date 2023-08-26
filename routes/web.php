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

Route::resource('package-categories', App\Http\Controllers\PackageCategoryController::class)->middleware('auth');
Route::resource('packages', App\Http\Controllers\PackageController::class)->middleware('auth');
Route::resource('privacy-policies', App\Http\Controllers\PrivacyPolicyController::class)->middleware('auth');
Route::resource('area-coverages', App\Http\Controllers\AreaCoverageController::class)->middleware('auth');
Route::resource('profile-pppoes', App\Http\Controllers\ProfilePppoeController::class)->middleware('auth');
Route::resource('active-ppps', App\Http\Controllers\ActivePppController::class)->middleware('auth');
Route::controller(App\Http\Controllers\SecretPppController::class)->group(function () {
    Route::put('enableSecret/{id}', 'enable')->name('secret-ppps.enable');
    Route::put('disableSecret/{id}', 'disable')->name('secret-ppps.disable');
});

Route::resource('secret-ppps', App\Http\Controllers\SecretPppController::class)->middleware('auth');

Route::resource('logs', App\Http\Controllers\LogController::class)->middleware('auth');
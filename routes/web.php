<?php

use App\Http\Controllers\DashboardController;
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


// FRONT END
Route::controller(App\Http\Controllers\Frontend\WebController::class)->group(function () {
    Route::get('/', 'index')->name('website');
});

Route::middleware(['auth', 'web'])->group(function () {
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', App\Http\Controllers\ProfileController::class)->name('profile');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleAndPermissionController::class);
});

// Route::get('/dashboard', function () {
//     return redirect()->route('dashboard');
// });

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
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
Route::controller(App\Http\Controllers\ActivePppController::class)->group(function () {
    Route::get('monitoring', 'monitoring')->name('monitoring');
});

Route::controller(App\Http\Controllers\SecretPppController::class)->group(function () {
    Route::put('enableSecret/{id}', 'enable')->name('secret-ppps.enable');
    Route::put('disableSecret/{id}/{name}', 'disable')->name('secret-ppps.disable');
    Route::delete('deleteSecret/{id}/{name}', 'deleteSecret')->name('secret-ppps.deleteSecret');
});

Route::resource('secret-ppps', App\Http\Controllers\SecretPppController::class)->middleware('auth');


Route::resource('logs', App\Http\Controllers\LogController::class)->middleware('auth');
Route::resource('dhcps', App\Http\Controllers\DhcpController::class)->middleware('auth');
Route::resource('interfaces', App\Http\Controllers\InterfaceController::class)->middleware('auth');
Route::resource('statics', App\Http\Controllers\StaticController::class)->middleware('auth');
Route::resource('settingmikrotiks', App\Http\Controllers\SettingmikrotikController::class)->middleware('auth');
Route::controller(App\Http\Controllers\SettingmikrotikController::class)->group(function () {
    Route::get('setActive', 'setActive')->name('setActive');
});
Route::resource('statusrouters', App\Http\Controllers\StatusrouterController::class)->middleware('auth');


Route::controller(App\Http\Controllers\StatusrouterController::class)->group(function () {
    Route::get('reboot', 'reboot')->name('reboot');
});

Route::resource('hotspotactives', App\Http\Controllers\HotspotactiveController::class)->middleware('auth');
Route::resource('hotspotusers', App\Http\Controllers\HotspotuserController::class)->middleware('auth');
Route::controller(App\Http\Controllers\HotspotuserController::class)->group(function () {
    Route::put('enableHotspot/{id}', 'enable')->name('hotspotusers.enable');
    Route::put('disableHotspot/{id}/{user}', 'disable')->name('hotspotusers.disable');
    Route::put('resetHotspot/{id}', 'reset')->name('hotspotusers.reset');
    Route::delete('deleteHotspot/{id}/{user}', 'deleteHotspot')->name('hotspotusers.delete');
    Route::get('mikhmon', 'mikhmon')->name('mikhmons.index');
});

Route::resource('odcs', App\Http\Controllers\OdcController::class)->middleware('auth');
Route::resource('odps', App\Http\Controllers\OdpController::class)->middleware('auth');

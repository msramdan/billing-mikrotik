<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormMikrotikController;
use App\Http\Controllers\PanelCustomer\DashboardController as PanelCustomerDashboardController;
use Illuminate\Support\Facades\Route;


// Callback Payment Tripay

Route::controller(App\Http\Controllers\PanelCustomer\TripayCallbackController::class)->group(function () {
    Route::post('/handle', 'handle')->name('handle');
});

// FRONT END - LANDING PAGE Public
Route::controller(App\Http\Controllers\Frontend\WebController::class)->group(function () {
    Route::get('/', 'index')->name('website');
    Route::get('/loginClient', 'loginClient')->name('loginClient');
    Route::get('/registerClient', 'registerClient')->name('registerClient');
    Route::post('/submitRegister', 'submitRegister')->name('submitRegister');
    Route::post('/submitLogin', 'submitLogin')->name('submitLogin');
    Route::get('/speedTest', 'speedTest')->name('speedTest');
    Route::get('/cekTagihan', 'cekTagihan')->name('cekTagihan');
    Route::get('/areaCoverage', 'areaCoverage')->name('areaCoverage');
});
// PANEL CUSTOMER Need Session
Route::middleware(['login-customer'])->group(function () {
    Route::controller(PanelCustomerDashboardController::class)->group(function () {
        Route::get('/dashboardCustomer', 'index')->name('dashboardCustomer');
        Route::get('/caraPembayaran', 'caraPembayaran')->name('caraPembayaran');
        Route::get('/showTagihan/{id}', 'showTagihan')->name('showTagihan');
        Route::get('/invoiceTagihan/{id}', 'invoiceTagihan')->name('invoiceTagihan');
        Route::get('/paymentList/{id}', 'paymentList')->name('paymentList');
        Route::get('/doPayment/{tagihan_id}/{metode}', 'doPayment')->name('doPayment');
        Route::get('/detailTagihan/{id}', 'detailTagihan')->name('detailTagihan');
    });
    Route::controller(App\Http\Controllers\Frontend\WebController::class)->group(function () {
        Route::get('/logoutCustomer', 'logoutCustomer')->name('logoutCustomer');
    });
});

// FORM INPUT MIKROTIK
Route::middleware(['auth', 'web','onmikrotik'])->group(function () {
    Route::controller(FormMikrotikController::class)->group(function () {
        Route::get('/form', 'form')->name('form');
        Route::post('/cekrouter', 'cekrouter')->name('api.cekrouter');
        Route::post('/simpanrouter', 'simpanrouter')->name('api.simpanrouter');
    });
});

// PANEL ADMIN
Route::middleware(['auth', 'web','nomikrotik'])->group(function () {
    Route::get('/profile', App\Http\Controllers\ProfileController::class)->name('profile');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleAndPermissionController::class);
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
    Route::resource('companies', App\Http\Controllers\CompanyController::class);
    Route::resource('banks', App\Http\Controllers\BankController::class);
    Route::resource('bank-accounts', App\Http\Controllers\BankAccountController::class);
    Route::resource('wa-gateways', App\Http\Controllers\WaGatewayController::class);
    Route::resource('package-categories', App\Http\Controllers\PackageCategoryController::class);
    Route::resource('packages', App\Http\Controllers\PackageController::class);
    Route::resource('privacy-policies', App\Http\Controllers\PrivacyPolicyController::class);
    Route::resource('area-coverages', App\Http\Controllers\AreaCoverageController::class);
    Route::resource('profile-pppoes', App\Http\Controllers\ProfilePppoeController::class);
    Route::resource('active-ppps', App\Http\Controllers\ActivePppController::class);
    Route::controller(App\Http\Controllers\ActivePppController::class)->group(function () {
        Route::get('monitoring', 'monitoring')->name('monitoring');
    });
    Route::controller(App\Http\Controllers\SecretPppController::class)->group(function () {
        Route::put('enableSecret/{id}', 'enable')->name('secret-ppps.enable');
        Route::put('disableSecret/{id}/{name}', 'disable')->name('secret-ppps.disable');
        Route::delete('deleteSecret/{id}/{name}', 'deleteSecret')->name('secret-ppps.deleteSecret');
    });
    Route::resource('secret-ppps', App\Http\Controllers\SecretPppController::class);
    Route::resource('logs', App\Http\Controllers\LogController::class);
    Route::resource('dhcps', App\Http\Controllers\DhcpController::class);
    Route::resource('interfaces', App\Http\Controllers\InterfaceController::class);
    Route::resource('statics', App\Http\Controllers\StaticController::class);
    Route::resource('settingmikrotiks', App\Http\Controllers\SettingmikrotikController::class);
    Route::controller(App\Http\Controllers\SettingmikrotikController::class)->group(function () {
        Route::get('setActive', 'setActive')->name('setActive');
    });
    Route::resource('statusrouters', App\Http\Controllers\StatusrouterController::class);
    Route::controller(App\Http\Controllers\StatusrouterController::class)->group(function () {
        Route::get('reboot', 'reboot')->name('reboot');
    });
    Route::resource('hotspotactives', App\Http\Controllers\HotspotactiveController::class);
    Route::resource('hotspotusers', App\Http\Controllers\HotspotuserController::class);
    Route::controller(App\Http\Controllers\HotspotuserController::class)->group(function () {
        Route::put('enableHotspot/{id}', 'enable')->name('hotspotusers.enable');
        Route::put('disableHotspot/{id}/{user}', 'disable')->name('hotspotusers.disable');
        Route::put('resetHotspot/{id}', 'reset')->name('hotspotusers.reset');
        Route::delete('deleteHotspot/{id}/{user}', 'deleteHotspot')->name('hotspotusers.delete');
        Route::get('mikhmon', 'mikhmon')->name('mikhmons.index');
    });
    Route::resource('odcs', App\Http\Controllers\OdcController::class);
    Route::resource('odps', App\Http\Controllers\OdpController::class);
    Route::resource('pelanggans', App\Http\Controllers\PelangganController::class);
    Route::controller(App\Http\Controllers\PelangganController::class)->group(function () {
        Route::get('setToExpired/{id}/{user_pppoe}', 'setToExpired')->name('pelanggans.setToExpired');
        Route::get('setNonToExpired/{id}/{user_pppoe}', 'setNonToExpired')->name('pelanggans.setNonToExpired');
        Route::get('getTableArea/{id}', 'getTableArea')->name('api.getTableArea');
        Route::get('getTableOdc/{id}', 'getTableOdc')->name('api.getTableOdc');
        Route::get('getTableOdp/{id}', 'getTableOdp')->name('api.getTableOdp');
    });

    Route::get('apiodc/{id}', [App\Http\Controllers\OdcController::class, 'odc'])->name('api.odc');
    Route::get('apiodp/{id}', [App\Http\Controllers\OdpController::class, 'odp'])->name('api.odp');
    Route::get('getPort/{id}', [App\Http\Controllers\OdpController::class, 'getPort'])->name('api.getPort');
    Route::get('getProfile/{id}', [App\Http\Controllers\OdpController::class, 'getProfile'])->name('api.getProfile');
    Route::resource('payment-tripays', App\Http\Controllers\PaymentTripayController::class);
    Route::resource('pemasukans', App\Http\Controllers\PemasukanController::class);
    Route::resource('pengeluarans', App\Http\Controllers\PengeluaranController::class);
    Route::resource('tagihans', App\Http\Controllers\TagihanController::class);
    Route::controller(App\Http\Controllers\TagihanController::class)->group(function () {
        Route::get('invoice/{id}', 'invoice')->name('invoice.pdf');
        Route::post('/bayarTagihan', 'bayarTagihan')->name('bayarTagihan');
    });
    Route::resource('laporans', App\Http\Controllers\LaporanController::class);
    Route::resource('sendnotifs', App\Http\Controllers\SendnotifController::class);
    Route::controller(App\Http\Controllers\SendnotifController::class)->group(function () {
        Route::post('/kirim_pesan', 'kirim_pesan')->name('kirim_pesan');
    });
    Route::resource('features', App\Http\Controllers\FeatureController::class);
});

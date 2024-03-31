<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpiredController;
use App\Http\Controllers\PanelCustomer\DashboardController as PanelCustomerDashboardController;
use App\Http\Controllers\SettingmikrotikController;
use Illuminate\Support\Facades\Route;


// Callback Payment Tripay
Route::controller(App\Http\Controllers\PanelCustomer\TripayCallbackController::class)->group(function () {
    Route::post('/handle', 'handle')->name('handle');
});

// FRONT END - LANDING PAGE Public
// Route::middleware(['cek-expired'])->group(function () {
Route::controller(App\Http\Controllers\Frontend\WebController::class)->group(function () {
    Route::get('/', 'index')->name('website');
    Route::get('/loginClient', 'loginClient')->name('loginClient');
    Route::post('/submitLogin', 'submitLogin')->name('submitLogin');
    Route::get('/cekTagihan', 'cekTagihan')->name('cekTagihan');
    Route::get('/bayar/{tagihan_id}/{metode}', 'bayar')->name('bayar');
    Route::get('/detailBayar/{id}', 'detailBayar')->name('detailBayar');
});
// });

// PANEL CUSTOMER Need Session
// Route::middleware(['login-customer', 'cek-expired'])->group(function () {
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
// });


// PANEL ADMIN
Route::middleware(['auth', 'web', 'cek-expired'])->group(function () {
    Route::get('/profile', App\Http\Controllers\ProfileController::class)->name('profile');
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard')->middleware('no_mikrotik');
    });
    Route::resource('banks', App\Http\Controllers\BankController::class);
    Route::resource('bank-accounts', App\Http\Controllers\BankAccountController::class);
    Route::resource('package-categories', App\Http\Controllers\PackageCategoryController::class);
    Route::resource('packages', App\Http\Controllers\PackageController::class);
    Route::resource('area-coverages', App\Http\Controllers\AreaCoverageController::class);
    Route::resource('profile-pppoes', App\Http\Controllers\ProfilePppoeController::class)->middleware('no_mikrotik');
    Route::resource('active-ppps', App\Http\Controllers\ActivePppController::class)->middleware('no_mikrotik');
    Route::resource('non-active-ppps', App\Http\Controllers\ActiveNonPppController::class)->middleware('no_mikrotik');
    Route::controller(App\Http\Controllers\ActivePppController::class)->group(function () {
        Route::get('monitoring', 'monitoring')->name('monitoring')->middleware('no_mikrotik');
    });
    Route::controller(App\Http\Controllers\SecretPppController::class)->group(function () {
        Route::put('enableSecret/{id}', 'enable')->name('secret-ppps.enable')->middleware('no_mikrotik');
        Route::put('disableSecret/{id}/{name}', 'disable')->name('secret-ppps.disable')->middleware('no_mikrotik');
        Route::delete('deleteSecret/{id}/{name}', 'deleteSecret')->name('secret-ppps.deleteSecret')->middleware('no_mikrotik');
    });
    Route::resource('hotspotprofiles', App\Http\Controllers\HotspotprofileController::class)->middleware('no_mikrotik');
    Route::controller(App\Http\Controllers\HotspotprofileController::class)->group(function () {
        Route::delete('deleteProfile/{id}/{name}', 'deleteProfile')->name('hotspotprofiles.deleteProfile')->middleware('no_mikrotik');
    });


    Route::resource('secret-ppps', App\Http\Controllers\SecretPppController::class)->middleware('no_mikrotik');
    Route::resource('logs', App\Http\Controllers\LogController::class)->middleware('no_mikrotik');
    Route::resource('dhcps', App\Http\Controllers\DhcpController::class)->middleware('no_mikrotik');
    Route::resource('interfaces', App\Http\Controllers\InterfaceController::class)->middleware('no_mikrotik');
    Route::resource('statics', App\Http\Controllers\StaticController::class)->middleware('no_mikrotik');
    Route::resource('settingmikrotiks', App\Http\Controllers\SettingmikrotikController::class);
    Route::controller(App\Http\Controllers\SettingmikrotikController::class)->group(function () {
        Route::get('setActive', 'setActive')->name('setActive')->middleware('no_mikrotik');
        Route::get('getMikrotikRouters', 'getMikrotikRouters')->name('getMikrotikRouters');
    });
    Route::resource('statusrouters', App\Http\Controllers\StatusrouterController::class)->middleware('no_mikrotik');
    Route::controller(App\Http\Controllers\StatusrouterController::class)->group(function () {
        Route::get('reboot', 'reboot')->name('reboot')->middleware('no_mikrotik');
    });
    Route::resource('hotspotactives', App\Http\Controllers\HotspotactiveController::class)->middleware('no_mikrotik');
    Route::resource('hotspotusers', App\Http\Controllers\HotspotuserController::class)->middleware('no_mikrotik');
    Route::controller(App\Http\Controllers\HotspotuserController::class)->group(function () {
        Route::put('enableHotspot/{id}', 'enable')->name('hotspotusers.enable')->middleware('no_mikrotik');
        Route::put('disableHotspot/{id}/{user}', 'disable')->name('hotspotusers.disable')->middleware('no_mikrotik');
        Route::put('resetHotspot/{id}', 'reset')->name('hotspotusers.reset')->middleware('no_mikrotik');
        Route::delete('deleteHotspot/{id}/{user}', 'deleteHotspot')->name('hotspotusers.delete')->middleware('no_mikrotik');
        Route::get('deleteByComment', 'deleteByComment')->name('hotspotusers.deleteByComment')->middleware('no_mikrotik');
        Route::get('cetakVoucher', 'cetakVoucher')->name('hotspotusers.cetakVoucher')->middleware('no_mikrotik');
    });
    Route::resource('odcs', App\Http\Controllers\OdcController::class);
    Route::resource('odps', App\Http\Controllers\OdpController::class);
    Route::resource('pelanggans', App\Http\Controllers\PelangganController::class);
    Route::controller(App\Http\Controllers\PelangganController::class)->group(function () {
        Route::get('setToExpired/{id}/{user_pppoe}', 'setToExpired')->name('pelanggans.setToExpired');
        Route::get('setNonToExpired/{id}/{user_pppoe}', 'setNonToExpired')->name('pelanggans.setNonToExpired');
        Route::get('setToExpiredStatic/{id}/{user_static}', 'setToExpiredStatic')
            ->name('pelanggans.setToExpiredStatic');
        Route::get('setNonToExpiredStatic/{id}/{user_static}', 'setNonToExpiredStatic')
            ->name('pelanggans.setNonToExpiredStatic');
        Route::get('getTableArea/{id}', 'getTableArea')->name('api.getTableArea');
        Route::get('getTableOdc/{id}', 'getTableOdc')->name('api.getTableOdc');
        Route::get('getTableOdp/{id}', 'getTableOdp')->name('api.getTableOdp');
    });

    Route::get('apiodc/{id}', [App\Http\Controllers\OdcController::class, 'odc'])->name('api.odc');
    Route::get('apiodp/{id}', [App\Http\Controllers\OdpController::class, 'odp'])->name('api.odp');
    Route::get('getPort/{id}', [App\Http\Controllers\OdpController::class, 'getPort'])->name('api.getPort');
    Route::get('getProfile/{id}', [App\Http\Controllers\OdpController::class, 'getProfile'])->name('api.getProfile');
    Route::get('getStatic/{id}', [App\Http\Controllers\OdpController::class, 'getStatic'])->name('api.getStatic');
    Route::resource('pemasukans', App\Http\Controllers\PemasukanController::class);
    Route::resource('pengeluarans', App\Http\Controllers\PengeluaranController::class);
    Route::resource('tagihans', App\Http\Controllers\TagihanController::class);
    Route::controller(App\Http\Controllers\TagihanController::class)->group(function () {
        Route::get('invoice/{id}', 'invoice')->name('invoice.pdf');
        Route::post('/bayarTagihan', 'bayarTagihan')->name('bayarTagihan');
        Route::post('/sendTagihanWa/{id}', 'sendTagihanWa')->name('sendTagihanWa');
        Route::post('/sendAll', 'sendAll')->name('sendAll');
    });
    Route::resource('laporans', App\Http\Controllers\LaporanController::class);
    Route::resource('sendnotifs', App\Http\Controllers\SendnotifController::class);
    Route::controller(App\Http\Controllers\SendnotifController::class)->group(function () {
        Route::post('/kirim_pesan', 'kirim_pesan')->name('kirim_pesan');
    });
});

Route::middleware(['auth', 'web'])->group(function () {
    Route::controller(ExpiredController::class)->group(function () {
        Route::get('/expired', 'expired')->name('expired');
    });

    Route::controller(SettingmikrotikController::class)->group(function () {
        Route::get('/nomikrotik', 'nomikrotik')->name('nomikrotik')->middleware('active_mikrotik');
    });

    Route::controller(App\Http\Controllers\CompanyController::class)->group(function () {
        Route::post('/update-session', 'updateSession')->name('updateSession');
        Route::post('/update-session-router', 'routerSelect')->name('routerSelect');
    });

    Route::resource('monitorings', App\Http\Controllers\MonitoringController::class);
    Route::controller(App\Http\Controllers\MonitoringController::class)->group(function () {
        Route::post('/update-session-olt', 'oltSelect')->name('oltSelect');
        Route::post('/detail-olt', 'detailOlt')->name('detailOlt');
        Route::post('/oltReboot', 'oltReboot')->name('oltReboot');
        Route::post('/oltReset', 'oltReset')->name('oltReset');
        Route::post('/oltHapus', 'oltHapus')->name('oltHapus');
        Route::get('/getProfile', 'getProfile')->name('getProfile');
        Route::post('/onuType', 'onuType')->name('onuType');
        Route::post('/tCon', 'tCon')->name('tCon');
        Route::post('/vlanProfile', 'vlanProfile')->name('vlanProfile');
        Route::post('/registerOnu', 'registerOnu')->name('registerOnu');
    });

    Route::resource('companies', App\Http\Controllers\CompanyController::class);
    Route::resource('pakets', App\Http\Controllers\PaketController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleAndPermissionController::class);
    Route::resource('olts', App\Http\Controllers\OltController::class);
    Route::resource('vouchers', App\Http\Controllers\VoucherController::class);
});

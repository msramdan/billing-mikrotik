<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['users.create', 'users.edit'], function ($view) {
            return $view->with(
                'roles',
                Role::select('id', 'name')->get()
            );
        });


        View::composer(['bank-accounts.create', 'bank-accounts.edit'], function ($view) {
            return $view->with(
                'banks',
                \App\Models\Bank::select('id', 'nama_bank')->get()
            );
        });


        View::composer(['packages.create', 'packages.edit'], function ($view) {
            return $view->with(
                'packageCategories',
                \App\Models\PackageCategory::select('id', 'nama_kategori')->get()
            );
        });

        View::composer(['odcs.create', 'odcs.edit'], function ($view) {
            return $view->with(
                'areaCoverages',
                \App\Models\AreaCoverage::select('id', 'kode_area')->get()
            );
        });

        View::composer(['odps.create', 'odps.edit'], function ($view) {
            return $view->with(
                'odcs',
                \App\Models\Odc::select('id', 'kode_odc')->get()
            );
        });

        View::composer(['odps.create', 'odps.edit'], function ($view) {
            return $view->with(
                'areaCoverages',
                \App\Models\AreaCoverage::select('id', 'kode_area')->get()
            );
        });

        View::composer(['pelanggans.create', 'pelanggans.edit'], function ($view) {
            return $view->with(
                'areaCoverages',
                \App\Models\AreaCoverage::select('id', 'kode_area','nama')->get()
            );
        });

        View::composer(['pelanggans.create', 'pelanggans.edit'], function ($view) {
            return $view->with(
                'odcs',
                \App\Models\Odc::select('id', 'kode_odc')->get()
            );
        });

        View::composer(['pelanggans.create', 'pelanggans.edit'], function ($view) {
            return $view->with(
                'odps',
                \App\Models\Odp::select('id', 'kode_odp')->get()
            );
        });

        View::composer(['pelanggans.create', 'pelanggans.edit'], function ($view) {
            return $view->with(
                'packages',
                \App\Models\Package::select('id', 'nama_layanan','harga')->get()
            );
        });

        View::composer(['pelanggans.create', 'pelanggans.edit'], function ($view) {
            return $view->with(
                'settingmikrotiks',
                \App\Models\Settingmikrotik::select('id', 'identitas_router')->get()
            );
        });
    }
}

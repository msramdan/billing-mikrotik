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

	}
}
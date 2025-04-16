<?php

namespace App\Providers;

use App\Models\Countries;
use App\Models\MediaFile;
use App\Models\Role;
use App\Models\User;
use App\Models\Warehousing;
use App\Observers\WarehousingObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Response::macro('success', function($message, $data = null, $status = 1) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'code' => 200
            ]);
        });

        Response::macro('failed', function($message, $data = null, $code = 500, $status = 0) {
            return response()->json([
                'status' => $status,
                'error' => $message,
                'data' => $data,
                'code' => $code
            ]);
        });

        $countries = Countries::query()->get();
        // TODO: need to change after role permission
        $headerUsers = User::getPartners();
        $headerAdmins = User::query()->where('role', 'admin')->get();
        $headerRoles = Role::query()->orderByDesc('id')->get();
        View::share('countries', $countries);
        View::share('header_users', $headerUsers);
        View::share('header_admins', $headerAdmins);
        View::share('header_roles', $headerRoles);

        // Forcing the HTTPS scheme in production environment
        if (config('app.env') == 'production') {
            URL::forceScheme('https');
        }

    }
}

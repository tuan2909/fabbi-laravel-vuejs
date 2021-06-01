<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use  App\Models\User;
use App\Repositories\User\UserRepository as CUser;
use App\Repositories\User\EloquentUserRepository as EUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRepository();
    }

    private function loadRepository()
    {
        $this->app->bind(CUser::class, function () {
            return new EUser(new User());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data = null,$message,$status) {
            return Response::json([
              'success'  => true,
              'message' => $message,
              'data' => $data,
            ],$status);
        });

        Response::macro('error', function ($message,$status = 400) {
            return Response::json([
              'success'  => false,
              'message' => $message,
            ],$status);
        });
    }
}

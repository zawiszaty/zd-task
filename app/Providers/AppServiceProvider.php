<?php

namespace App\Providers;

use App\Repository\Articles;
use App\Repository\ArticlesEloquentRepository;
use App\Repository\ResetCodePasswordEloquentRepository;
use App\Repository\ResetCodePasswords;
use App\Repository\Users;
use App\Repository\UsersEloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            Articles::class,
            ArticlesEloquentRepository::class
        );

        $this->app->bind(
            Users::class,
            UsersEloquentRepository::class
        );

        $this->app->bind(
            ResetCodePasswords::class,
            ResetCodePasswordEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

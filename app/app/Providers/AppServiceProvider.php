<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias(PersonalAccessToken::class, \App\Models\PersonalAccessToken::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

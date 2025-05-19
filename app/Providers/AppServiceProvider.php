<?php

namespace App\Providers;

use App\Http\Controllers\PackageController;
use App\Http\Controllers\FoodController;
use App\Interfaces\BaseRepoInterface;
use App\Interfaces\PackageSearchInterface;
use App\Interfaces\FoodSearchInterface;
use App\Services\PackageService;
use App\Services\FoodService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Auth\AuthInterface;
use App\Services\Auth\AuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(AuthInterface::class, AuthService::class);
        
        $this->app->when(PackageController::class)
        ->needs(BaseRepoInterface::class)
        ->give(PackageService::class);

    $this->app->when(PackageController::class)
        ->needs(PackageSearchInterface::class)
        ->give(PackageService::class);


    $this->app->when(FoodController::class)
        ->needs(BaseRepoInterface::class)
        ->give(FoodService::class);
        
    $this->app->when(FoodController::class)
        ->needs(FoodSearchInterface::class)
        ->give(FoodService::class);

    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

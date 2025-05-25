<?php

namespace App\Providers;

use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\Food\FoodController;
use App\Interfaces\BaseRepoInterface;
use App\Interfaces\PackageSearchInterface;
use App\Interfaces\FoodSearchInterface;
use App\Services\PackageService;
use App\Services\FoodService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Auth\AuthInterface;
use App\Services\Auth\AuthService;
use App\Interfaces\Auth\SocialAuthInterface;
use App\Services\Auth\GoogleAuthService;
use App\Interfaces\Booking\BookingInterface;
use App\Services\Booking\BookingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Auth
        $this->app->bind(AuthInterface::class, AuthService::class);

        $this->app->when(GoogleAuthController::class)
        ->needs(SocialAuthInterface::class)
        ->give(GoogleAuthService::class);
    
        $this->app->when(FacebookAuthController::class)
        ->needs(SocialAuthInterface::class)
        ->give(FacebookAuthService::class);
    
        //Package
        $this->app->when(PackageController::class)
        ->needs(BaseRepoInterface::class)
        ->give(PackageService::class);

        $this->app->when(PackageController::class)
        ->needs(PackageSearchInterface::class)
        ->give(PackageService::class);

        //Food
        $this->app->when(FoodController::class)
        ->needs(BaseRepoInterface::class)
        ->give(FoodService::class);
        
        $this->app->when(FoodController::class)
        ->needs(FoodSearchInterface::class)
        ->give(FoodService::class);
        
        //Booking/Reservation
        $this->app->bind(BookingInterface::class, BookingService::class);

    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

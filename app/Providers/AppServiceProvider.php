<?php

namespace App\Providers;

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
        //
    }

    public static function redirectToByUserRole(): string
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $role = $user?->userType?->name ?? null;

        return match ($role) {
            'admin' => '/admin/dashboard',
            'insegnante' => '/insegnante/dashboard',
            'studente' => '/studente/dashboard',
            default => '/dashboard', // fallback
        };
    }
}

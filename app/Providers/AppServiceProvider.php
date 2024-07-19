<?php

namespace App\Providers;

use App\Events\UserRegistration;
use App\Listeners\SendVerificationEmail;
use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        Event::listen(
            UserRegistration::class,
            SendVerificationEmail::class,
        );

        Gate::define('update-business', function (User $user, Business $business) {
            return $user->id === $business->user_id;
        });
    }
}

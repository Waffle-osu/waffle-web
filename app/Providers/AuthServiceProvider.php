<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Hashing\OsuHasher;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Register our custom bcrypt driver
        $this->app->make('hash')->extend('bcrypt', function() {
            return new OsuHasher();
        });
    }
}

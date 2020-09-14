<?php

namespace App\Providers;

use App\Policies\Admin\UpdatePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerUpdatePolicies();
    }

    protected function registerUpdatePolicies()
    {
        Gate::define('view-new-version', [UpdatePolicy::class, 'checkVersion']);
        Gate::define('update-app-version', [UpdatePolicy::class, 'updateApp']);
    }
}

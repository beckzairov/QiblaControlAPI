<?php

namespace App\Providers;

use App\Models\Agreement;
use App\Policies\AgreementPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Agreement::class => AgreementPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function boot()
    {
        $this->registerPolicies(); // Registers all policies
        Gate::policy(Agreement::class, AgreementPolicy::class);
    }
}


<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class InertiaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Inertia::share('tenant', function () {
            return tenancy()?->tenant?->only([
                'id',
                'tenancy_db_name',
                'name',
                'email',
            ]);
        });
    }
}

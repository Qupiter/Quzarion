<?php

namespace App\Console\Commands;

use App\Models\Central\Tenant;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Stancl\Tenancy\Facades\Tenancy;
use Symfony\Component\Console\Command\Command as CommandAlias;

class AddTenantRole extends Command
{
    protected $signature = 'tenant:add-role
                            {tenant_name : The name of the tenant (e.g., tenant1)}
                            {role_name : The name of the role to create}
                            {--guard=web : The guard name to use (default: web)}';

    protected $description = 'Adds a role to a specific tenant by tenant name';

    public function handle()
    {
        $tenantName = $this->argument('tenant_name');
        $roleName = $this->argument('role_name');
        $guard = $this->option('guard');

        $tenant = Tenant::where('name', $tenantName)->first();

        if (! $tenant) {
            $this->error("❌ Tenant with name [$tenantName] not found.");
            return CommandAlias::FAILURE;
        }

        $this->info("Initializing tenant [$tenantName]...");
        Tenancy::initialize($tenant);

        $this->info("Creating role [$roleName] with guard [$guard]...");

        $role = Role::firstOrCreate([
            'name' => $roleName,
            'guard_name' => $guard,
        ]);

        $this->info("✅ Role [$roleName] created successfully in tenant [$tenantName]'s database.");

        return CommandAlias::SUCCESS;
    }
}

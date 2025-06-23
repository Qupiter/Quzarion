<?php

namespace App\Console\Commands;

use App\Models\Central\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Facades\Tenancy;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create
                            {--name= : The unique tenant ID (e.g., tenant1)}
                            {--domain= : The domain for the tenant (e.g., tenant1.quzarion.test)}
                            {--db= : Optional custom DB name (defaults to tenant_{id})}';

    protected $description = 'Creates a tenant with a separate database, domain, and runs migrations';

    public function handle()
    {
        $id = uuid_create();
        $name = $this->option('name') ?? $this->ask('Tenant ID (e.g., tenant1)');
        $domain = $this->option('domain') ?? $this->ask('Tenant domain (e.g., tenant1.quzarion.test)');
        $dbName = $this->option('db') ?? 'tenant_' . $id;

        $this->info("Creating tenant [$id] with DB [$dbName] and domain [$domain]...");

        $tenant = Tenant::create([
            'id' => uuid_create(),
            'name'  => $name,
            'email' => $domain . '@gmail.com',
            'password' => Hash::make($name),
            'tenancy_db_name' => $dbName
        ]);

        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        $this->info('Tenant created. Running tenant migrations...');

        Tenancy::initialize($tenant);

        $this->info('Connected to DB: ' . DB::connection()->getDatabaseName());

        $this->call('migrate', [
            '--path' => '/database/migrations/tenant',
            '--force' => true,
        ]);

        $this->info("Tenant DB [$dbName] migrated.");

        $this->info("✅ Tenant [$name] created successfully and migrated.");
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Central\Tenant;
use Illuminate\Console\Command;

class DeleteAllTenants extends Command
{
    protected $signature = 'tenants:delete-all {--force : Skip confirmation}';
    protected $description = 'Deletes all tenants, their databases, and domains';

    public function handle()
    {
        if (!$this->option('force') &&
            !$this->confirm('Are you ABSOLUTELY sure you want to delete ALL tenants? This will drop tenant databases and remove tenant records.')) {
            $this->warn('❌ Aborted.');
            return;
        }

        $tenants = Tenant::all();

        if ($tenants->isEmpty()) {
            $this->info('No tenants found.');
            return;
        }

        foreach ($tenants as $tenant) {
            $tenant->delete();
            $this->info("✅ Deleted tenant: {$tenant->id}");
        }

        $this->info('🎉 All tenants and their databases have been deleted.');
    }
}

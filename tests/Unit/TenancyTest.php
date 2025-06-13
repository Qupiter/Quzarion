<?php

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_for_tenant()
    {
        $tenant = Tenant::create(['id' => 'tenant1']);

        tenancy()->initialize($tenant);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@tenant1.test',
            'password' => bcrypt('secret'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@tenant1.test',
            'tenant_id' => 'tenant1',
        ]);

        tenancy()->end();
    }

    public function test_creating_user_outside_tenant_context_should_fail()
    {
        $this->expectException(QueryException::class);

        User::create([
            'name' => 'Orphaned User',
            'email' => 'orphan@example.com',
            'password' => bcrypt('no-tenant'),
        ]);
    }
}

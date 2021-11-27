<?php

namespace Tests\Feature\Api;

use App\Models\Plan;
use App\Models\Tenant;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TenantTest extends TestCase
{
    /**
     * Test Get All Tenants
     *
     * @return void
     */
    public function testGetAllTenants()
    {
        Tenant::factory()->count(10)->create();

        $response = $this->getJson('/api/v1/tenants');
       // $response->dump();

        $response->assertStatus(200)
                    ->assertJsonCount(10, 'data');
    }

    /**
     * Test Get Error Single Tenant
     *
     * @return void
     */
    public function testErrorGetTenants()
    {
        $tenant = 'fake_value';

        $response = $this->getJson("/api/v1/tenants/{$tenant}");

        $response->assertStatus(404);
    }

    /**
     * Test Get Tenant By Identify
     *
     * @return void
     */
    public function testGetTenantByIdentify()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tenants/{$tenant->uuid}");
        //$response->dump();

        $response->assertStatus(200);
    }
}

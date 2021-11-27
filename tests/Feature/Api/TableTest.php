<?php

namespace Tests\Feature\Api;

use App\Models\Table;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TableTest extends TestCase
{
    /**
     * Error get Tables by Tenant
     *
     * @return void
     */
    public function testGetAllTablesByTenantError()
    {
        $response = $this->getJson('/api/v1/tables');

        $response->assertStatus(422);
    }

    /**
     * Get Tables by Tenant
     *
     * @return void
     */
    public function testGetAllTablesByTenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tables?token_company={$tenant->uuid}");
        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * Error Get Category By Tenant
     *
     * @return void
     */
    public function testErrorGetCategoryByTenant()
    {
        $category = 'fake_value';
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tables{$category}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * Get Table By Tenant
     *
     * @return void
     */
    public function testGetTableByTenant()
    {
        $table = Table::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/tables/{$table->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}

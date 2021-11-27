<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Error get categories by Tenant
     *
     * @return void
     */
    public function testGetAllCategoriesByTenantError()
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(422);
    }

    /**
     * Get categories by Tenant
     *
     * @return void
     */
    public function testGetAllCategoriesByTenant()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/categories?token_company={$tenant->uuid}");
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

        $response = $this->getJson("/api/v1/categories{$category}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * Get Category By Tenant
     *
     * @return void
     */
    public function testGetCategoryByTenant()
    {
        $category = Category::factory()->create();
        $tenant = Tenant::factory()->create();

        $response = $this->getJson("/api/v1/categories/{$category->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
